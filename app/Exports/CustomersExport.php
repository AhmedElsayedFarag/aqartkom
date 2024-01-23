<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\Auth\Entities\User as EntitiesUser;

class CustomersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return EntitiesUser::role('customer')->select(['id', 'name', 'phone', 'email'])->get();
    }
}
