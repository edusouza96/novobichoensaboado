<?php

namespace BichoEnsaboado\Http\Middleware;

use Closure;
use Carbon\Carbon;
use BichoEnsaboado\Repositories\CashBookRepository;

class CashdeskStatus
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
        $store = 1;
        $cashBookRepository = app(CashBookRepository::class);
        $status =  $cashBookRepository->findByDate(Carbon::now(), $store);

        return $status 
            ? $next($request) 
            : redirect()
                ->route('dashboard.index')
                ->with('alertType', 'warning')
                ->with('message', 'Abra o caixa antes de realizar alguma operação.');
    }
}
