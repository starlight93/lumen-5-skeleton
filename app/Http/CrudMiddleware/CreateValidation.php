<?php

namespace App\Http\CrudMiddleware;

use Closure;
use Validator;

class CreateValidation
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

        $validator = Validator::make( $request->all() , [
            
        ] );
        if ( $validator->fails() ) {
            return response()->json( [
                "code"=>422,
                "message"=> $validator->errors()
            ], 422 );
        }
        return $next($request);
    }
}
