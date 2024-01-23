<?php

namespace App\Helpers;

trait AddCountryCode
{
    public function getValidatorInstance()
    {

        $this->addCountryCode();
        return parent::getValidatorInstance();
    }

    protected function addCountryCode()
    {

        $this->merge([
            'phone' => "+9665" . $this->request->get('phone'),
        ]);
        if ($this->request->has('whatsapp_number'))
            $this->merge([
                'whatsapp_number' => "+9665" . $this->request->get('whatsapp_number'),
            ]);
    }
}