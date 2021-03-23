<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrudController extends Controller
{
    public function __construct()
    {
        //
    }
    public function index( Request $r, $table = null, $id = null ){
        
        if( $r->method()=='GET' && $table===null){
            $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
            return [
                "resources" => array_values( array_filter( $tables, function($dt) { 
                    return strpos($dt , 'oauth') === false && !in_array( $dt, [
                        "migrations"
                    ]);
                } ) )
            ];
        }
        
        if ( !Schema::hasTable( $table ) ){
            abort(404, json_encode([
                "message"=>"resource $table does not exist"
            ]));
        }else{
            $q = DB::table( $table );
        }

        switch( strtolower( $r->method() ) ){
            case "post":
                $id = $q->insertGetId( array_merge( $request->all(), [
                    "created_at"=>"NOW()", "updated_at" => "NOW()"
                ] ) );
                return (array) $q->find( $id );
                break;
            case "put":
            case "patch":
                $q->where( "id", $id )->update( array_merge( $request->all(), [
                    "updated_at" => "NOW()"
                ] ) );
                return (array) $q->find( $id );
                break;
            case "delete":
                $id = $q->where( "id", $id )->delete();
                break;
            default:
                if( $id !==null ){
                    $data = $q->find( $id );
                    return $data? (array) $data:response()->json([
                        "message" => "id $id in resource $table does not exist"
                    ],404);
                }else{
                    return $q->paginate( $r->has("paginate") ? $r->paginate : 25 );
                }
        }
    }
}
