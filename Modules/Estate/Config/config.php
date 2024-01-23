<?php

use Illuminate\Validation\Rule;
use Modules\Estate\Entities\EstateAttribute;

return [
    'name' => 'Estate',
    'validation_rules' => [
        'estate'                    => 'required|array',
        'estate.city'               => 'required|numeric|exists:cities,id',
        'estate.category'           => 'required|numeric|exists:categories,id',
        'estate.title'              => 'required|string|min:3|max:50',
        'estate.address'            => 'required|string|min:3|max:120',
        'estate.description'        => 'required|string|min:3|max:1000',
        'estate.area'               => 'required|numeric|min:1',
        'estate.lat'                => 'required|numeric|min:-180|max:180',
        'estate.long'               => 'required|numeric|min:-180|max:180',


        'details.*.attribute'       => 'required|numeric|min:1',
        'details.*.value'           => 'required',
    ],
    'media_validation_rule' => [
        'media'                     => 'required|array|min:2|max:15',
        'media.*'                   => 'required|string|uuid|exists:media,uuid',
    ],
    'update_media_validation_rule' => [
        'new_media'                 => 'sometimes|array',
        'new_media.*'               => 'required|string|uuid|exists:media,uuid',
        'deleted_media'             => 'sometimes|array',
        'deleted_media.*'           => 'required|string|uuid|exists:estate_media,uuid',
    ],
    'category_is_building_validation_rules' => [
        'estate.age'                => 'required|numeric|min:0|max:100',
        'estate.is_furniture'       => 'required|boolean',
        'estate.bedroom'           => 'required|numeric|min:0|max:50',
    ],
    'filter_validation_rules' => [
        'type'          => 'sometimes|string|in:rent,sell',
        'prices'        => 'sometimes|array|size:2',
        'prices.0'      => 'numeric|lt:prices.1',
        'prices.1'      => 'numeric|gt:prices.0',
        'age'           => 'sometimes|array|size:2',
        'age.0'         => 'numeric|lt:age.1',
        'age.1'         => 'numeric|gt:age.0',
        'bedroom'        => 'sometimes|array|min:1',
        'area'        => 'sometimes|array|size:2',
        'area.0'      => 'numeric|lt:area.1',
        'area.1'      => 'numeric|gt:area.0',
        'category'      => 'sometimes|numeric|exists:categories,id',
        'category_array'      => 'sometimes|array',
        'category_array.*'      => 'sometimes|numeric|exists:categories,id',
        'city'          => 'sometimes|numeric|exists:cities,id',
        'neighborhood'  => 'sometimes|numeric|exists:neighborhoods,id',

    ],
];