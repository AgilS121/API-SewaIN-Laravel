<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Members;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MemberResource;
use App\Http\Resources\UserResource;


class AuthenticationController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Ambil user dari tabel users
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ], 400);
        }

        if ($user->is_verified == 0) {
            return response()->json([
                'message' => 'Please verify your email address first.',
            ], 401);
        }

        $member = Members::where('id_users', $user->id)->first();

        // Periksa apakah user adalah member atau bukan
        if ($member !== null && $member->status == "members") {
            // Buat token untuk member
            $token = $member->createToken('member login')->plainTextToken;
            $status = "sukses member";
        } else {
            // Buat token untuk user
            $token = $user->createToken('user login')->plainTextToken;
            $status = "sukses penyewa";
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'status' => $status,
            'member' => $member ?? null,
        ],200);
    }




    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }

    public function me(Request $request)
    {
        $dataLogin = Auth::user();
        // dd($dataLogin);
        if ($dataLogin->status == "members") {
            // return response()->json($dataLogin);
            $member = Members::with(['users_member'])->findOrFail($dataLogin->id);
            return new MemberResource($member);
        }

        if ($dataLogin->status == "penyewa") {
            return response()->json($dataLogin);
        }
    }

}
