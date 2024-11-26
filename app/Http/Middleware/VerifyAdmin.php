<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class VerifyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth_admin = DB::table('admins')->where('email',Auth::guard('admin')->user()->email)->first();
        if( $auth_admin->email_verified_at == null )
        {
            return  redirect()->route('admin.login.form')
                ->with(['error','کاربر گرامی ابتدا وارد سایت شوید.']);
        }
        return $next($request);
    }
}
