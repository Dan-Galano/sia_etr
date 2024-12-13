<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectToCorrectHomePage
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user->type === 'organizer' && $request->route()->getName() === 'member-home') {
            return redirect()->route('organizer-home');
        }

        if ($user->type === 'member' && $request->route()->getName() === 'organizer-home') {
            return redirect()->route('member-home');
        }

        return $next($request);
    }
}
