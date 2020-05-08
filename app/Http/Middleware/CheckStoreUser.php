<?php

namespace BichoEnsaboado\Http\Middleware;

use Closure;

class CheckStoreUser
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
        if(!$request->session()->has('userLoggedCurrenteStore')){
            if(auth()->user()->stores->count() > 1){
                return redirect()->route('auth-definition.selectCurrenteStore');
            }

            $request->session()->put('userLoggedCurrenteStore', auth()->user()->getStore()->getId());
        }

        return $next($request);
    }
}
