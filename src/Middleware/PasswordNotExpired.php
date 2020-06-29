<?php


namespace Axterisko\Inspinia\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PasswordNotExpired
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!Auth::check() || in_array($request->route()->getName(),['password.expired','password.renew'])) {
            return $next($request);
        }

        if ((config('inspinia.force_password_change', true)
                && Auth::user()->hasNoPasswordHistory())
            || Auth::user()->hasExpiredPassword()) {

            if ($request->ajax())
                return response()->json([
                    'message' => trans('inpsinia::auth.renew.password_expired')
                ], 401);

            return redirect()->route('password.expired');
        }

        return $next($request);
    }

}
