<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\SewaResource;
use App\Models\Sewas;
use Illuminate\Support\Facades\Auth;

class SewaController extends Controller
{
    public function index()
    {
        $sewa = Sewas::all();
        // dd($sewa);

        return SewaResource::collection($sewa);
    }

    public function show($id)
    {
        $sewa = Sewas::with(['sewa_barang', 'sewa_users'])->findOrFail($id);

        return new SewaResource($sewa);
    }

    public function store(Request $request)
    {
        $apakahLogin = Auth::check();

        if($apakahLogin == true)
        {
            $dataLogin = Auth::user();
            if ($dataLogin->status == "members"){
                $validated = $request->validate([
                    'id_barang' => 'required',
                    'durasi_sewa' => 'required',
                    'jumlah_sewa' => 'required',
                ]);
                // dd($dataLogin->id_users);
                $request['id_penyewa'] = $dataLogin->id_users;
                $sewa = Sewas::create($request->all());
                return new SewaResource($sewa->loadMissing('sewa_users:id,name'));
            } else if($dataLogin->status == "penyewa") {
                $validated = $request->validate([
                    'id_barang' => 'required',
                    'durasi_sewa' => 'required',
                    'jumlah_sewa' => 'required',
                ]);
                // dd($dataLogin->id);
                $request['id_penyewa'] = $dataLogin->id;
                $sewa = Sewas::create($request->all());
                return new SewaResource($sewa->loadMissing('sewa_users:id,name'));
            } else {
                return response()->json([
                    'message' => 'Login Terlebih Dahulu'
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Unauthorized',
            ]);
        }
    }

    public function update(Request $request, $id)
    {

            $validated = $request->validate([
                'id_barang' => 'required',
                'durasi_sewa' => 'required',
                'jumlah_sewa' => 'required'
            ]);

            $sewa = Sewas::findOrFail($id);
            $sewa->update($request->all());
            return new SewaResource($sewa->loadMissing('sewa_users:id,name'));

    }

    public function destroy($id)
    {
        $sewa = Sewas::findOrFail($id);
        $sewa->delete();

        return new SewaResource($sewa->loadMissing('sewa_users:id,name'));
    }


}
