<?php

namespace Modules\Auction\Transformers;

use App\Helpers\PriceFormatter;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Estate\Transformers\EstateResource;

class AuctionResource extends JsonResource
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
            'uuid' => $this->uuid,
            'code' => "AUC" . str_pad($this->id, 2, 0, STR_PAD_LEFT),
            'initial_price' => PriceFormatter::format($this->initial_price),
            'top_price' => PriceFormatter::format($this->top_price),
            'is_closed' => $this->is_closed,
            'end_at' => $this->end_at,
            'estate' => new EstateResource($this->estate),
            // 'is_participant' => $this->bids()->where('user_id', auth()->id())->exists()
        ];
    }
}