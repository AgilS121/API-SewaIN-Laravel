<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Barangs;
use Illuminate\Support\Facades\Auth;

class BarangPosting
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
        $barang = Barangs::findOrFail($request->id);

        if($barang->id_member != $currentUser->id)
        {
            return response()->json(['message' => 'data not found'], 404);
        }
        return $next($request);
    }
}
