<?php

namespace Modules\Ad\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AdFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $values = [];
        if ($this->group == 'age') {
            foreach ($this->values as $value) {
                $values[] = [
                    'name' => $value['name'],
                    'values' => \array_map(fn ($value) => (int)$value, $value['values'])
                ];
            }
        } else {
            foreach ($this->values as $value) {
                $values[] = (int)$value;
            }
        }

        return [
            'name' => $this->name,
            'group' => $this->group,
            'type' => $this->group == 'age' ? 'radio' : 'select',
            'values' => $values,
        ];
    }
}