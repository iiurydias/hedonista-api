<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Helpers\Functions;
use Closure;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle($request, Closure $next,...$guards)
    {
        $data = $request->all();
        if(array_key_exists('token', $data)){
            if (User::where('api_token', '=', $data['token'])->count() == 0) {
            return Functions::sendError('Busca nao autorizada', "", 403);     
            }
            return $next($request);
        }else{
            return Functions::sendError('Token não fornecido', "", 403);     
        }
    }
}
