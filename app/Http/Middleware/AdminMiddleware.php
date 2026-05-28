<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Importamos a Facade Auth oficial aqui

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Acesso negado. Você não é um administrador.');
        }

        return $next($request);
    }
}
