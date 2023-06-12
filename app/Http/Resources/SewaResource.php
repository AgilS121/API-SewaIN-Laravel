<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SewaResource extends JsonResource
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
            'id_barang' => $this->id_barang,
            'id_penyewa' => $this->id_penyewa,
            'durasi_sewa' => $this->durasi_sewa,
            'jumlah_sewa' => $this->jumlah_sewa,
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
            'barang' => $this->whenLoaded('sewa_barang', function () {
                return [
                    'id' => $this->sewa_barang->id,
                    'nama_barang' => $this->sewa_barang->nama_barang,
                ];
            }),
            'penyewa' => $this->whenLoaded('sewa_users', function () {
                return [
                    'id' => $this->sewa_users->id,
                    'name' => $this->sewa_users->name
                ];
            })
        ];
    }
}
