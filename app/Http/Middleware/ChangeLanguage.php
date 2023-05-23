<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\helpers\helper;


class ChangeLanguage
{

    public function __construct()
    {
       $this->helper = new helper();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
  
    public function handle(Request $request, Closure $next)
    {
        if($request->hasHeader("Accept-Language"))
        {
            app()->setLocale($request->header('Accept-Language'));

        }
        
        return $next($request);
    }

   








}
