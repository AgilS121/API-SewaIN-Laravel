<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MidtransResource extends JsonResource
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
            'id_sewa' => $this->id_sewa,
            'status' => $this->status,
            'payment_type' => $this->payment_type,
            'transaction_time' => $this->transaction_time,
            'gross_amount' => $this->gross_amount,
            'transaction_id' => $this->transaction_id,
            'va_number' => $this->va_number,
            'bank' => $this->bank,
            'create_at' => date_format($this->created_at, "Y/m/d H:i:s"),
            'sewa' => $this->whenLoaded('midtrans_sewa', function () {
                return [
                    'id' => $this->midtrans_sewa->id,
                ];
            })
        ];
    }
}
