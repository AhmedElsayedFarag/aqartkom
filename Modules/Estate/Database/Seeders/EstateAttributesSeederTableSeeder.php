<?php

namespace Modules\Estate\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Category\Entities\Category;
use Modules\Estate\Entities\EstateAttribute;

class EstateAttributesSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();

        {
            Model::unguard();
            $categories = Category::select(['id'])->get();
            $data = [
                [
                    'name' => 'عدد الصالات',
                    'type' => 'number',

                ],
                [
                    'name' => 'عدد دورة المياه',
                    'type' => 'number',

                ],
                [
                    'name' => 'غرفة السائق',
                    'type' => 'radio',
                    'values' => [
                        'نعم', 'لا'
                    ]
                ],
                [
                    'name' => 'مسبح',
                    'type' => 'radio',
                    'values' => [
                        'نعم', 'لا'
                    ]
                ],
                [
                    'name' => 'مصعد',
                    'type' => 'radio',
                    'values' => [
                        'نعم', 'لا'
                    ]
                ],
                [
                    'name' => 'حوش',
                    'type' => 'radio',
                    'values' => [
                        'نعم', 'لا'
                    ]
                ],
                [
                    'name' => 'مطبخ',
                    'type' => 'radio',
                    'values' => [
                        'نعم', 'لا'
                    ]
                ],

            ];
            foreach ($categories as $category)
                foreach ($data as  $value) {
                    $attribute = EstateAttribute::create([
                        ...Arr::only($value, [
                            'name',
                            'type',
                        ]),
                        'category_id' => $category->id,
                    ]);
                    $type = $value['type'];
                    if ($type == 'select' || $type == 'radio') {
                        $formattedValues = [];
                        foreach ($value['values'] as $val) {
                            $formattedValues[] = [
                                'value' => $val,
                                'estate_attribute_id' => $attribute->id,
                                'created_at' => now()->toDateTimeString(),
                                'updated_at' => now()->toDateTimeString(),
                            ];
                        }
                        $attribute->values()->insert($formattedValues);
                    }
                }
            // $this->call("OthersTableSeeder");
        }
    }
}
