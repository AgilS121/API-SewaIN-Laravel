<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'id_kategori' => $this->id_kategori,
            'id_subkategori' => $this->id_subkategori,
            'id_member' => $this->id_member,
            'durasi_sewa' => $this->durasi_sewa,
            'nama_barang' => $this->nama_barang,
            'deskripsi' => $this->deskripsi,
            'image' => $this->image,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
            'kategori' => $this->whenLoaded('barang_kategori', function () {
                return [
                    'id' => $this->barang_kategori->id,
                    'nama_kategori' => $this->barang_kategori->nama_kategori
                ];
            }),
            'sub_kategori' => $this->whenLoaded('barang_subkategori', function () {
                return [
                    'id' => $this->barang_subkategori->id,
                    'nama_subkategori' => $this->barang_subkategori->nama_subkategori
                ];
            }),
            'member' => $this->whenLoaded('barang_member', function () {
                return [
                    'id' => $this->barang_member->id,
                    'nama_tempat' => $this->barang_member->nama_tempat
                ];
            })
        ];
    }
}
