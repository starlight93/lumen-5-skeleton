<?php

namespace App\Http\CrudMiddleware;

use Closure;

class MergeOnUpdate
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

        $request->request->add([
            // 'name'=>'aloha2'
        ]);
        
        return $next($request);
    }
}
