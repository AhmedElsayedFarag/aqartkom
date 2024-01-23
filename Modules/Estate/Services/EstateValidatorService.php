<?php

namespace Modules\Estate\Services;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Estate\DataTransferObject\EstateDetailsDto;

class EstateValidatorService
{
    protected array $attributes = [];
    protected array $selectAttributes = [];
    protected array $numberAttributes = [];
    protected array $stringAttributes = [];
    protected array $validationMessages = [];

    /**
     * data is the estate key of the request (!important)
     * sequence to validate estate dynamic attributes
     * first there are two types of attributes => 1)select or radio attributes (pre defined)
     * 2) user defined values
     * to validate predefined =>1)get the attributes of the category
     * 2) check there is missing attributes of the category or not relate to the category
     * 3)check the value is relate to the attribute or not
     * for the user defined attributes , validate against specific rule
     */
    public function __construct(protected EstateDetailsDto $estateDetailsDto)
    {
    }
    public function validate()
    {
        $this->validateMissingAttributes();
        $this->validateSelectAttributeValues();
        $this->validateInputAttributes('required|numeric|min:1|max:100', $this->estateDetailsDto->getNumberAttributes());
        $this->validateInputAttributes('required|string|min:3|max:120', $this->estateDetailsDto->getStringAttributes());
    }

    private function validateMissingAttributes()
    {
        $this->throwException($this->estateDetailsDto->getMissingAttributes());
    }

    private function validateSelectAttributeValues()
    {
        $values = $this->getSelectValues();
        $invalidValues = [];
        foreach ($values as $key => $value) {
            $attribute = $this->estateDetailsDto->getSelectAttribute($key);
            if (!isset($value[$this->estateDetailsDto->getValue($key)])) {
                $invalidValues[] = $attribute;
            }
        }
        $this->throwException($invalidValues);
    }
    private function validateInputAttributes(string $rule, array $attributes)
    {
        $attributeNames = array_column($attributes, 'name');
        $rules = \array_fill_keys($attributeNames, $rule);
        $validatingData = [];
        foreach ($attributes as $key => $value) {
            $validatingData[$value->name] = $this->estateDetailsDto->getValue($key);
        }
        validator()->make($validatingData, $rules)->validate();
    }


    private function formatMessages(array $keys)
    {
        $validationMessages = [];
        foreach ($keys as $key => $value) {
            $validationMessages[] = __('validation.required', ['attribute' => $value->name]);
        }
        return $validationMessages;
    }

    private function throwException($invalidArray)
    {
        if (count($invalidArray))
            throw  ValidationException::withMessages($this->formatMessages($invalidArray));
    }
    private function getSelectValues(): array
    {
        return DB::table('estate_attribute_values')
            ->select(['id', 'estate_attribute_id'])
            ->whereIn('estate_attribute_id', array_keys($this->estateDetailsDto->getSelectAttributes()))
            ->get()
            ->groupBy('estate_attribute_id')
            ->map(function ($value) {
                return $value->keyBy('id');
            })
            ->toArray();
    }
    public function validateCategoryAttributes(array $data)
    {
        validator()
            ->make($data, config('estate.category_is_building_validation_rules'))
            ->validate();
    }
}