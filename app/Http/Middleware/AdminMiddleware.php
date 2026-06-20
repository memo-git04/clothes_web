<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login.page-login')
                ->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }
        if (!Auth::user()->hasAnyRole(['admin', 'manager', 'staff'])) {
            Auth::logout();
            return redirect()->route('admin.loginAdmin')->with('error', 'Không có quyền truy cập.');
        }
        return $next($request);
    }
}
