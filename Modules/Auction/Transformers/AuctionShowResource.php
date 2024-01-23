<?php

namespace Modules\Auction\Transformers;

use App\Helpers\PriceFormatter;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Estate\Transformers\EstateShowResource;

class AuctionShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'uuid' => $this->uuid,
            'code' => "AUC" . str_pad($this->id, 2, 0, STR_PAD_LEFT),
            'initial_price' => PriceFormatter::format(
                $this->initial_price
            ),
            'top_price' => $this->top_price,
            'calculated_area' => PriceFormatter::format($this->top_price * $this->estate->area),
            'is_closed' => $this->is_closed,
            'end_at' => $this->end_at,
            'estate' => new EstateShowResource($this->estate),
            'link' => $this->shareLink,
            'is_favorite' => $this->is_favorite ?? false,
        ];
        if (auth('sanctum')->check()) {
            $data = [
                ...$data,
                'is_participant' => $this->bids()->where('user_id', auth('sanctum')->id())->exists(),
                'is_accepted' => $this->bids()->where([
                    ['user_id', auth('sanctum')->id()],
                    ['status', 'approved']
                ])->exists()
            ];
        }
        return $data;
    }
}