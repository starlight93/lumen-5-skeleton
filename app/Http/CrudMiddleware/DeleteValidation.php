<?php

namespace App\Http\CrudMiddleware;

use Closure;
use Validator;

class DeleteValidation
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
        $id    =  $request->route()[2]['id'] ?? NULL;
        
        return $next($request);
    }
}
