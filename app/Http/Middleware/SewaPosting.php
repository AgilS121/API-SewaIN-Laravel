<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Sewas;
use Illuminate\Support\Facades\Auth;

class SewaPosting
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
        $sewa = Sewas::findOrFail($request->id);

        if($sewa->id_penyewa == $currentUser->id_users || $sewa->id_penyewa == $currentUser->id)
        {
            return $next($request);
        }
        abort(404, 'Data Not Found');

    }
}
