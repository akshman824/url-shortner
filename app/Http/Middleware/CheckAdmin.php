<?php

// app/Http/Middleware/CheckAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Assuming you have a method or role check for the user
        if (auth()->user() && auth()->user()->role == 'admin') {
            return $next($request);  // Proceed to the requested route if user is admin
        }

        // Redirect to the homepage or login if the user is not an admin
        return redirect('/');  // Or you can redirect to a 403 page
    }
}

