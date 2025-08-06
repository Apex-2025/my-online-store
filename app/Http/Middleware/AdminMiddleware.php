<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            // Якщо користувач не авторизований або не є адміністратором,
            // перенаправляємо його на головну сторінку.
            return redirect('/');
        }

        return $next($request);
    }
}
