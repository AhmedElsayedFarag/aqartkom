<?php

namespace Modules\Ad\DataTransferObject;

use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;

class AdDto
{

    private int $estateID;
    private ?string $instrumentNumber = null;
    private string $advertiserRelation;
    private ?string $licenseNumber = null;
    private ?string $buildingNumber = null;
    private ?string $additionalNumber = null;
    private ?string $postalNumber = null;
    private int $categoryID;
    private ?float $area;
    private ?int $adTypeID = null;
    private ?string $nationalityNumber = null;
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
            // 'ad_type_id'        => $this->adTypeID,
            'estate_id'         => $this->estateID,
            "instrument_number" => $this->instrumentNumber,
            "advertiser_relation" => $this->advertiserRelation,
            'license_number' => $this->licenseNumber,

            'building_number' => $this->buildingNumber,
            'additional_number' => $this->additionalNumber,
            'postal_number' => $this->postalNumber,
        ];
        if ($this->nationalityNumber)
            $data['nationality_id'] = $this->nationalityNumber;
        if (\strpos(\request()->url(), 'license-ad-request') !== false || \strpos(\request()->url(), 'ad-market') !== false) {
            $date['license_number'] = null;
        }
        // $categoryID = request()->get('estate')['category'];

        if ($this->type == 'sell' && $this->isPriceMeters()) {
            // $data['price'] = \floatval(request()->get('price')) * \floatval(request()->get('estate')['area']);
            $data['price'] = \floatval($this->price) * \floatval($this->area);
            $data['price_of_meters'] = \floatval($this->price);
        } else
            $data['price'] = $this->price;


        $data['ad_type_id']  = $this->addAdType();
        return $data;
    }
    public function uniqueKeys(): array
    {
        return [
            'user_id' => $this->owner->id,
            'estate_id' => $this->estateID,
        ];
    }
    public function addAdType()
    {
        if ($this->type === 'sell' && is_null($this->adTypeID))
            return 1; //sell type

        if ($this->type == 'rent' && is_null($this->adTypeID))
            return 4; //rent type

        return $this->adTypeID;
    }
    public function getOwner(): User
    {
        return $this->owner;
    }
    public function setCategoryID(int $categoryID): self
    {
        $this->categoryID = $categoryID;

        return $this;
    }
    public function setInstrumentNumber(string $instrumentNumber): self
    {
        $this->instrumentNumber = $instrumentNumber;
        return $this;
    }
    public function setAdvertiserRelation(string $advertiserRelation): self
    {
        $this->advertiserRelation = $advertiserRelation;
        return $this;
    }
    public function setLicenseNumber(string $licenseNumber): self
    {
        $this->licenseNumber = $licenseNumber;
        return $this;
    }
    public function setArea(?float $area): self
    {
        $this->area = $area;
        return $this;
    }
    public function setAdTypeID(int $adTypeID): self
    {
        $this->adTypeID = $adTypeID;
        return $this;
    }
    private function isPriceMeters(): bool
    {
        return DB::table('categories')
            ->where('id', $this->categoryID)
            ->where('is_price_per_meter', true)
            ->exists();
    }
    public function setBuildingNumber(string $buildingNumber)
    {
        $this->buildingNumber = $buildingNumber;
        return $this;
    }
    public function setAdditionalNumber(string $additionalNumber)
    {
        $this->additionalNumber = $additionalNumber;
        return $this;
    }
    public function setPostalNumber(string $postalNumber)
    {
        $this->postalNumber = $postalNumber;
        return $this;
    }
    public function setNationalityNumber(string $nationalityNumber): self
    {
        $this->nationalityNumber = $nationalityNumber;
        return $this;
    }
}