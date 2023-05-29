<?php

namespace App\Http\Middleware;

use App\Models\Comments;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikKomen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id_komentator = Comments::findOrFail($request->id)->user_id;
        $user = Auth::user()->id;
        if($id_komentator != $user){
            return response()->json('kamu bukanlah pemilik komentar');
        } 
        return $next($request);
    }
}
