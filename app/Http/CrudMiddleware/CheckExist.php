<?php

namespace App\Http\CrudMiddleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $table =  $request->route()[2]['table'] ?? NULL; //change this on laravel later version
        $id =  $request->route()[2]['id'] ?? NULL;
        if( $request->method()=='GET' && $table === NULL){
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
            return response()->json([
                "code"=>404,
                "message"=>"resource `$table` does not exist"
            ],404);
        }
        if( $id !== NULL ){
            if ( !is_numeric($id) ){
                return response()->json([
                    "code"=>404,
                    "message" => "Parameter ID must be an Integer, `$id` is a String"
                ],404);
            }
            $rowExist = \DB::table( $table )->find( $id );
            if( !$rowExist ){
                return response()->json([
                    "code"=>404,
                    "message" => "Id `$id` in Resource `$table` does not exist"
                ],404);
            }
        }
        
        return $next($request);
    }
}
