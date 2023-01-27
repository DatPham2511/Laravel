<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use App\Models\Admin;
use Auth;
class AccessPermission
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
        if(Auth::user()){
            if(Auth::user()->hasRole('Admin')){
                return $next($request);
            }else{
                return redirect('/dashboard');
            }
        }
        else{
            return redirect()->back();
        }


    }
}
