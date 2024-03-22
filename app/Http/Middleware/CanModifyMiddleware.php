<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CanModifyMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if ($request->user()->can_modify) {
            return $next($request);
        }

        return Inertia::render('Error403');
    }
}
