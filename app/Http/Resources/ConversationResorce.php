<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Models\User;

class ConversationResorce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data['id'] = $this->id;
        // $data['user'] = Auth::user()->id_users == $this->id_users;
        // $data['user'] = Auth::user()->id_users == $this->id_user ? new UserResource(User::find($this->id_user)) : null ;
        $data['user'] = Auth::user()->id == $this->id_user ? new UserResource(User::find($this->encode_id_user)) : new UserResource(User::find($this->id_user))  ;
        $data['created_at'] = $this->created_at;
        $data['message'] = MessageResource::collection($this->messages);
        return $data;
    }
}
