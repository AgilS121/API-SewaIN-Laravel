<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Kategories;
use Illuminate\Support\Facades\Auth;

class KategoriPosting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $currentUser = Auth::user();
        $kategori = Kategories::findOrFail($request->id);

        if($kategori->id_member != null)
        {
            return response()->json(['message' => 'data not found'], 404);
        }
        return $next($request);
    }
}
