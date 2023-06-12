<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'id_users' => $this->id_users,
            'nama_tempat' => $this->nama_tempat,
            'lokasi' => $this->lokasi,
            'no_wa' => $this->no_wa,
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
            'user' => $this->whenLoaded('users_member', function () {
                return [
                    'id' => $this->users_member->id,
                    'name' => $this->users_member->name,
                    'email' => $this->users_member->email,
                    'alamat' => $this->users_member->alamat,
                    'image' => $this->users_member->image,
                ];
            })
        ];
    }
}
