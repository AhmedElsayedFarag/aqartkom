<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\Auth\Entities\User as EntitiesUser;

class OwnersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return EntitiesUser::role('owner')->select(['id', 'name', 'phone', 'email'])->get();
    }
}
