<?php
// <!-- apart bestand puur voor het contoleren of je een admin bent  -->


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        //Controleer of de gebruiker ingelogd is EN of hij admin is
        if (!Auth::check() || !Auth::user()->is_admin) {
            // Als dat niet zo is, geef een 403 Forbidden foutmelding of stuur terug
            abort(403, 'Toegang geweigerd: Je hebt admin-rechten nodig.');
        }

        return $next($request);
    }
}