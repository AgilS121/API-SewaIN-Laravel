<?php

namespace App\Http\Controllers;

use App\Models\Kategories;
use Illuminate\Http\Request;
use App\Models\Subkategories;
use App\Http\Resources\KategoriesResource;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $kategories = Kategories::all();

        // penggunaakan key
        // return response()->json(['data' => $kategories]);
        // penggunaan menggunakan collection api resources di laravel
        return KategoriesResource::collection($kategories);
    }

    public function show($id)
    {
        $kategories = Kategories::findOrFail($id);

        return response()->json(['data' => $kategories]);
    }

    public function store(Request $request)
    {

        $dataLogin = Auth::user();

        if ($dataLogin->status=="members") {
                // return response()->json('ok');
                $validated = $request->validate([
                    'nama_kategori' => 'required|max:255'
                ]);

            $request['id_member'] = $dataLogin->id;
            $kategori = Kategories::create($request->all());
            return new KategoriesResource($kategori);
        } else {
            return response()->json([
                'message' => 'Unauthorized',
            ],401);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|max:255'
        ]);

        $kategori = Kategories::findOrFail($id);
        // Cek apakah kategori dipakai oleh subkategori
        $subkategori_count = Subkategories::where('id_kategori', $kategori->id)->count();
        if ($subkategori_count > 0) {
            return response()->json([
                'message' => 'Data sedang digunakan oleh subkategori dan tidak bisa diupdate'
            ]);
        } else {
            $kategori->update($request->all());
            return new KategoriesResource($kategori);
        }
    }

    public function destroy($id)
    {
        $kategori = Kategories::findOrFail($id);
        // Cek apakah kategori dipakai oleh subkategori
        $subkategori_count = Subkategories::where('id_kategori', $kategori->id)->count();

        if ($subkategori_count > 0) {
            return response()->json([
                'message' => 'Data sedang digunakan oleh subkategori dan tidak bisa dihapus'
            ]);
        } else {
            $kategori->delete();
            return new KategoriesResource($kategori);
        }
    }
}
