<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       $ln='en';
       if($request->language) { $ln=$request->language;}
       else if($request->login_token) { 
        $u=getUser($request->login_token);
        if($u){
        $default_lang=$u->language;
          if($default_lang){
            $ln=$default_lang;
          }
        }

       } 
       app()->setLocale($ln);
       return $next($request);
    }
    
}
