<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class CrudController extends Controller
{

    public function index( Request $r, $table = null, $id = null )
    {        
        $q = DB::table( $table );
        switch( strtolower( $r->method() ) ){
            case "post":
                $id = $q->insertGetId( array_merge( $r->all(), [
                    "created_at"=>Carbon::now(), "updated_at" => Carbon::now()
                ] ) );
                return (array) $q->find( $id );
                break;
            case "put":
            case "patch":
                $q->where( "id", $id )->update( array_merge( $r->all(), [
                    "updated_at" => Carbon::now()
                ] ) );
                $data = $q->first();
                return $data?(array) $data:response()->json([
                    "code"=>404,
                    "message" => "id $id in resource $table does not exist"
                ],404);
                break;
            case "delete":
                $res = $q->where( "id", $id )->delete();
                return response()->json([
                    "code"=>$res==1||$res===true?200:404,
                    "message" => $res==1||$res===true?"id $id in resource $table has been deleted successfully":"id $id in $table does not exist"
                ]);
                break;
            default:
                if( $id !==null ){
                    $data = $q->find( $id );
                    return $data? (array) $data:response()->json([
                        "code"=>404,
                        "message" => "id $id in resource $table does not exist"
                    ],404);
                }else{
                    return $q->paginate( $r->has("paginate") ? $r->paginate : 25 );
                }
        }
    }
}
