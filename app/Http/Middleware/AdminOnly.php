<?php

namespace App\Http\Middleware;

use Closure;

class AdminOnly
{
    public function handle($request, Closure $next)
    {
        if (! is_user_logged_in() || ! current_user_can('manage_options')) {
            return redirect(wp_login_url());
        }

        return $next($request);
    }
}
