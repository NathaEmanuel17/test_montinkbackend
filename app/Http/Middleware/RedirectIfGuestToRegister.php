<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfGuestToRegister
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('register')->with('message', 'Você precisa criar uma conta antes de adicionar produtos ao carrinho.');
        }

        return $next($request);
    }
}

