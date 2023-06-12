<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // ketika mengembalikan semua data yang ada pada database tanpa terkecuali
        // return parent::toArray($request);

        // ketika mengembalikan data pada database sesuai dengan apa yang dipilih
        return [
            'id' => $this->id,
            'nama_kategori' => $this->nama_kategori
        ];
    }
}
