<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Members;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function memberRegistrasi(Request $request)
    {
        $dataLogin = Auth::user();

        $validator = Validator::make($request->all(), [
            'nama_tempat' => 'required|max:255',
            'lokasi' => 'required',
            'no_wa' => 'required|numeric'
        ]);

        $member = Members::create([
            'id_users' => $dataLogin->id,
            'nama_tempat' => $request->nama_tempat,
            'lokasi' => $request->lokasi,
            'no_wa' => $request->no_wa,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Anda berhasil mendaftar sebagai member',
        ], 201);

    }
}
