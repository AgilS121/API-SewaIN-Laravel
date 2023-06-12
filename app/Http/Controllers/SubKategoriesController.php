<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subkategories;
use App\Http\Resources\SubkategoriesResource;
use App\Http\Resources\SubkategoriesDetailResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Barangs;

class SubKategoriesController extends Controller
{
    public function index()
    {
        $subkategori = Subkategories::all();

        // return response()->json(['data' => $subkategori]);
        return SubkategoriesDetailResource::collection($subkategori);
    }

    public function show($id)
    {
        $subkategori = Subkategories::with('nkategori:id,nama_kategori')->findOrFail($id);

        return new SubkategoriesDetailResource($subkategori);
    }

    public function show2($id)
    {
        $subkategori = Subkategories::findOrFail($id);

        return new SubkategoriesDetailResource($subkategori);
    }

    public function store(Request $request)
    {

        $dataLogin = Auth::user();

        if ($dataLogin->status=="members") {
                // return response()->json('ok');
                $validated = $request->validate([
                    'id_kategori' => 'required',
                    'nama_subkategori' => 'required|max:255'
                ]);

            $request['id_member'] = $dataLogin->id;
            $subkategori = Subkategories::create($request->all());
            return new SubkategoriesDetailResource($subkategori->loadMissing('nkategori:id,nama_kategori'));
        } else {
            return response()->json([
                'message' => 'Unauthorized',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_kategori' => 'required',
            'nama_subkategori' => 'required|max:255'
        ]);

        $subkategori = Subkategories::findOrFail($id);

        $barang_count = Barangs::where('id_subkategori', $subkategori->id)->count();
        if ($barang_count > 0) {
            return response()->json([
                'message' => 'Data sedang digunakan oleh barang dan tidak bisa diupdate'
            ]);
        } else {
            $subkategori->update($request->all());
            return new SubkategoriesDetailResource($subkategori->loadMissing('nkategori:id,nama_kategori'));
        }
    }

    public function destroy($id)
    {
        $subkategori = Subkategories::findOrFail($id);
        $barang_count = Barangs::where('id_subkategori', $subkategori->id)->count();
        if ($barang_count > 0) {
            return response()->json([
                'message' => 'Data sedang digunakan oleh barang dan tidak bisa diupdate'
            ]);
        } else {
            $subkategori->delete();
            return new SubkategoriesDetailResource($subkategori->loadMissing('nkategori:id,nama_kategori'));
        }
    }
}

