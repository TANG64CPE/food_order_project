<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ตรวจสอบว่าล็อกอินแล้ว และ เป็นแอดมิน (is_admin == true)
        if (Auth::check() && Auth::user()->is_admin) {
            // ถ้าใช่ ให้ไปต่อ
            return $next($request);
        }

        // ถ้าไม่ใช่ ให้เด้งกลับไปหน้า Home
        return redirect('/');
    }
}
