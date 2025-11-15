<?php

namespace App\Http\Middleware;

use App\Models\ArchivedAccount;
use App\Models\NewAccount;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::findOrfail(Auth::user()->id);
        if ($user->user_type == 'user') {
            // Prevent access if user is archived
            if (ArchivedAccount::where('user_id', $user->id)->count() > 0) {
                abort(401);
            }
            return $next($request);
        }
        return to_route('home');
    }
}
