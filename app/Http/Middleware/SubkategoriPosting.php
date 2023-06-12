<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Subkategories;
use Illuminate\Support\Facades\Auth;

class SubkategoriPosting
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
        $subkategori = Subkategories::findOrFail($request->id);

        if($subkategori->id_member != null)
        {
            return response()->json(['message' => 'data not found'], 404);

        }
        return $next($request);
    }
}
