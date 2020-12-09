<?php

namespace App\Http\Middleware;

use Closure;
user Illuminate\Support\Facades\Auth; //mengecek authenticaty yang sedah ia jalankan

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user() && Auth::user()->roles == 'ADMIN') //apakah user ter auth ato tidak? panah roles dari migration == apakah ia admin atau bukan, jika iya maka return 
        {
        return $next($request); //jika admin maka dia login, jika bukan maka
        }
        return redirect('/'); //ke halaman utama
        // setelah membuat auth lari ke Kernel.php
    }
}