<?php

namespace Modules\Auction\Transformers;

use App\Helpers\PriceFormatter;
use Illuminate\Http\Resources\Json\JsonResource;

class BidRequestResource extends JsonResource
{
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
            'amount' => PriceFormatter::format($this->amount),
            'auction' => new AuctionResource($this->auction),
        ];
    }
}