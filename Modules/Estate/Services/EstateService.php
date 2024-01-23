<?php

namespace Modules\Estate\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Modules\Category\Entities\Category;
use Modules\Estate\DataTransferObject\EstatableDto;
use Modules\Estate\DataTransferObject\EstateDetailsDto;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Entities\Estate;
use Modules\Estate\Entities\EstateMedia;
use Modules\Media\Entities\Media;
use Modules\Media\Services\LocalMediaService;
use Modules\Media\Services\RemoteMediaService;
use Illuminate\Support\Str;

class EstateService
{
    /**
     * flow of creating estate
     * 1)check category is building to validate the attributes of category
     * 2)validate attributes
     * 3)insert details
     * 4)move media
     */
    private array $estateData;
    public function __construct()
    {
    }

    public function createOrUpdate(EstateDto $estateDto, Estate $estate = null): Estate
    {
        $estateDetailsService   = new EstateDetailService($estateDto->getEstateDetails());
        $validatorService = new EstateValidatorService($estateDto->getEstateDetails());
        if (count($estateDto->details))
            $validatorService->validate();
        $isBuilding = $this->isCategoryBuilding($estateDto->getCategory());
        if ($isBuilding)
            $validatorService->validateCategoryAttributes($estateDto->toArray());
        $this->addAdditionalData($estateDto->estate);
        $this->estateData['is_building'] = $isBuilding;
        DB::transaction(function () use ($estateDetailsService, $estateDto, &$estate) {
            if (\is_null($estate)) {
                $estate = Estate::create($this->estateData);
            } else
                $estate->update($this->estateData);
            if (count($estateDto->media))
                $this->moveMedia($estate, $estateDto->media);
            if (count($estateDto->deletedMedia))
                $this->deleteMedia($estateDto->deletedMedia);
            if (count($estateDto->details))
                $estate->details()->upsert(
                    $estateDetailsService->create($estate->id),
                    ['estate_id', 'estate_attribute_id']
                );
            if (count($estateDto->details) == 0) {
                $estate->details()->delete();
            }
        });
        return $estate;
    }
    public function addAdditionalData(array $estateData)
    {
        $this->estateData = [
            ...$estateData,
            'city_id' => $estateData['city'],
            'category_id' => $estateData['category'],
            'neighborhood_id' => isset($estateData['neighborhood']) ? $estateData['neighborhood'] : null,
            'age' => $estateData['age'] ?? null,
            'bedroom' => $estateData['bedroom'] ?? null,
            'is_building' => $estateData['is_building'] ?? false,
            'is_furniture' => $estateData['is_furniture'] ?? false,
        ];
    }
    public function moveMedia(Estate $estate, array $media)
    {

        $retrievedMedia = Media::select(['uuid', 'url', 'type', 'storage_location'])
            ->whereIn('uuid', $media)
            ->get();
        $firstImage = $retrievedMedia->where('type', 'image')->first();

        $mediaCount = EstateMedia::where('estate_id', $estate->id)->where('type', 'image')->count();
        $formattedMedia  = $retrievedMedia->map(function ($m) use ($estate, $firstImage, $mediaCount) {
            if (!\is_null($firstImage))
                $m->is_cover =  ($mediaCount == 0 && $m->uuid == $firstImage->uuid);
            $m->estate_id = $estate->id;
            return $m;
        })->toArray();
        $estate->media()->insert($formattedMedia);
        Media::whereIn('uuid', $media)->delete();
    }
    public function deleteMedia(array $media)
    {
        $localMediaService = new LocalMediaService();
        $remoteMediaService = new RemoteMediaService();
        $estateMedia = EstateMedia::select(['id', 'url', 'storage_location'])
            ->whereIn('uuid', $media)
            ->get()
            ->each(function (EstateMedia $media) use ($localMediaService, $remoteMediaService) {
                if ($media->storage_location == 'local')
                    $localMediaService->delete($media->url);
                else
                    $remoteMediaService->delete($media->url);
            });

        EstateMedia::whereIn('uuid', $media)->delete();
    }
    public function isCategoryBuilding(int $categoryID)
    {
        return Category::select(['is_building'])->find($categoryID)->is_building;
    }
    public function generateMedia(int $estateID)
    {
        return [
            [
                'uuid' => Str::uuid(),
                'url' => 'default/estates/1.png',
                'type' => 'image',
                'storage_location' => 'local',
                'estate_id' => $estateID,
            ],
            [
                'uuid' => Str::uuid(),
                'url' => 'default/estates/2.png',
                'type' => 'image',
                'storage_location' => 'local',
                'estate_id' => $estateID,
            ],
            [
                'uuid' => Str::uuid(),
                'url' => 'default/estates/3.png',
                'type' => 'image',
                'storage_location' => 'local',
                'estate_id' => $estateID,
            ], [
                'uuid' => Str::uuid(),
                'url' => 'default/estates/4.png',
                'type' => 'image',
                'storage_location' => 'local',
                'estate_id' => $estateID,
            ], [
                'uuid' => Str::uuid(),
                'url' => 'default/estates/5.png',
                'type' => 'image',
                'storage_location' => 'local',
                'estate_id' => $estateID,
            ],
            [
                'uuid' => Str::uuid(),
                'url' => 'default/estates/6.png',
                'type' => 'image',
                'storage_location' => 'local',
                'estate_id' => $estateID,
            ],
        ];
    }
    public static function formatDetails($estate): array
    {
        $formattedDetails = [
            [
                'title' => __('validation.attributes.area'),
                'value' => (string) $estate->area,
                'unit' => __('admin.attribute_units.meter'),
            ]
        ];
        if ($estate->is_building) {
            $formattedDetails = [
                ...$formattedDetails,
                [
                    'title' => __('validation.attributes.bedroom'),
                    'value' => (string) $estate->bedroom,
                    'unit' => __('admin.attribute_units.bedroom'),
                ],
                [
                    'title' => __('validation.attributes.age'),
                    'value' => (string) $estate->age,
                    'unit' => __('admin.attribute_units.year'),
                ],
            ];
        }
        foreach ($estate->details as $detail) {
            $formattedDetails[] = [
                'title' => $detail->attribute->name,
                'value' => $detail->attributeValue?->value ?? $detail->value['value'] . "",
                'unit' => $detail->attribute->unit,
            ];
        }
        return $formattedDetails;
    }
}
