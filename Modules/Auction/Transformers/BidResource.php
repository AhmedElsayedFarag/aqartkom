<?php

namespace Modules\Auction\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auction\Entities\BidRequest;

class BidResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'amount' => (int)$this->amount,
            'total' => (int)$this->total,
            'name' => $this->name,
            'phone' => \str_replace("+966", "", $this->phone),
            'national_number' => $this->national_number,
            'status' => $this->status,
        ];
    }
}