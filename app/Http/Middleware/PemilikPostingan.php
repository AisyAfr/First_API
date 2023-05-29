<?php

namespace App\Http\Middleware;

use App\Models\posts;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikPostingan
{
    public function handle(Request $request, Closure $next): Response
    {
        $id_author = posts::findOrfail($request->id);
        $user = Auth::user();
        if($id_author->author != $user->id){
            return response()->json('kamu bukanlah pemilik postingan');
        }
        return $next($request);
    }
}
