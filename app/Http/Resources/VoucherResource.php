<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
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
            "id" => $this->id,
            "code" => $this->code,
            "customer_id" => $this->customer_id,
            "photo" => $this->photo,
            "reserved_datetime" => $this->reserved_datetime,
            "max_upload_datetime" => $this->max_upload_datetime,
            "redeemable" => $this->redeemable
        ];
    }
}
