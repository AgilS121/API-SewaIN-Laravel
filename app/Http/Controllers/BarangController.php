<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BarangResource;
use App\Models\Barangs;
use App\Models\Members;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barangs::all();

        return BarangResource::collection($barang);
    }

    public function show($id)
    {
        $barang = Barangs::with(['barang_kategori', 'barang_subkategori', 'barang_member'])->findOrFail($id);

        return new BarangResource($barang);
    }

    public function store(Request $request)
    {
        $dataLogin = Auth::user();
        if ($dataLogin->status == "members") {
            $validated = $request->validate([
                'id_kategori' => 'required',
                'id_subkategori' => 'required',
                'durasi_sewa' => 'required|array',
                'nama_barang' => 'required|max:255',
                'deskripsi' => 'required',
                'harga' => 'required',
                'stok' => 'required'
            ]);

            $requestData = $request->except('image');
            // $requestData = $request->except(['image', 'durasi_sewa']);
            $requestData['id_member'] = $dataLogin->id;

            if ($request->hasFile('image')) {
                $imageName = $this->generateRandomString();
                $extension = $request->image->getClientOriginalExtension();
                $imageNameWithExtension = $imageName . '.' . $extension;

                Storage::putFileAs('images', $request->image, $imageNameWithExtension);
                $requestData['image'] = $imageNameWithExtension;
            }

            $barang = Barangs::create($requestData);

            return new BarangResource($barang->loadMissing('barang_member:id,nama_tempat'));
        } else {
            return response()->json([
                'message' => 'Unauthorized',
            ],401);
        }
    }



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_kategori' => '',
            'id_subkategori' => '',
            'nama_barang' => 'required|max:255',
            'deskripsi' => 'required',
            'durasi_sewa' => 'required|array',
            'image' => '',
            'harga' => '',
            'stok' => ''
        ]);

        $barang = Barangs::findOrFail($id);
        $barang->update($request->all());

        return new BarangResource($barang->loadMissing('barang_member:id,nama_tempat'));
    }

    public function destroy($id)
    {
        $barang = Barangs::findOrFail($id);
        $barang->delete();

        return new BarangResource($barang->loadMissing('barang_member:id,nama_tempat'));
    }

    function generateRandomString($length = 30)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
