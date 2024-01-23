<?php

namespace Modules\Ad\DataTransferObject;

use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;

class AdRequestDto
{
    private int $estateID;
    public function __construct(
        private string $type,
        private ?string $price,
        private User $owner,
    ) {
    }
    public function setEstateID(int $estateID)
    {
        $this->estateID = $estateID;
        return $this;
    }
    public function toArray(): array
    {

        $data =  [
            'user_id'           => $this->owner->id,
            'owner_name'        => $this->owner->name,
            'owner_phone'       => $this->owner->phone,
            'type'              => $this->type,
            'estate_id'         => $this->estateID
        ];
        $categoryID = request()->get('estate')['category'];
        $isPriceMeters = DB::table('categories')
            ->where('id', $categoryID)
            ->where('is_price_per_meter', true)
            ->exists();
        if ($this->type == 'sell' && $isPriceMeters) {
            $data['price'] = \intval(request()->get('price')) * \intval(request()->get('estate')['area']);
            $data['price_of_meters'] = \intval(request()->get('price'));
        } else {
            $data['price'] = $this->price;
        }

        $this->addAdType($data);
        return $data;
    }
    public function uniqueKeys(): array
    {
        return [
            'user_id' => $this->ownerID,
            'estate_id' => $this->estateID,
        ];
    }
    public function addAdType(&$data)
    {
        if ($this->type === 'sell' && is_null(request()->get('type_id'))) {
            $data['ad_type_id'] = 1;
        } else if ($this->type == 'rent' && is_null(request()->get('type_id'))) {
            $data['ad_type_id'] = 4;
        } else {
            $data['ad_type_id'] = request()->get('type_id');
        }
    }
}