<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Assurez-vous d'importer la façade Auth
use Symfony\Component\HttpFoundation\Response;

class GestionnaireMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Utilisation correcte de la façade Auth pour vérifier l'utilisateur authentifié
        if (Auth::check() && Auth::user()->role === 'gestionnaire') {
            return $next($request);
        }

        // Si l'utilisateur n'est pas un gestionnaire, redirigez-le
        return redirect()->route('dashboard')->with('error', 'Accès réservé aux gestionnaires.');
    }
}