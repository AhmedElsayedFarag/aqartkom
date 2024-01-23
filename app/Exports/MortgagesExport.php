<?php

namespace App\Exports;

use App\DataTransferObjects\MortgageExportDto;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Mortgage\Entities\Mortgage;
use Modules\Transaction\Entities\Transaction;

class MortgagesExport implements FromQuery, WithHeadings, WithMapping
{

    use Exportable;
    public function __construct(
        private MortgageExportDto $dto,
    ) {
    }
    public function headings(): array
    {

        return [
            '#',
            __('validation.attributes.name'),
            __('validation.attributes.phone'),
            __('validation.attributes.email'),
            __('validation.attributes.gender'),
            __('validation.attributes.age'),
            __('validation.attributes.bank'),
            __('validation.attributes.group'),
            __('validation.attributes.salary'),
            __('validation.attributes.area'),
            __('validation.attributes.nationality'),

        ];
    }
    public function query()
    {
        return Mortgage::query()
            ->search($this->dto->search)
            ->age($this->dto->age)
            ->bank($this->dto->bank)
            ->area($this->dto->area)
            ->latest()
            ->limit(2000);
    }
    /**
     * @var Invoice $invoice
     */
    public function map($mortgage): array
    {
        return [
            $mortgage->id,
            $mortgage->name,
            $mortgage->phone,
            $mortgage->email,
            $mortgage->gender == 'male' ? 'ذكر' : 'انثى',
            __('mortgage.age')[$mortgage->age],
            __('mortgage.bank')[$mortgage->bank],
            __('mortgage.group')[$mortgage->group],
            __('mortgage.salary')[$mortgage->salary],
            __('mortgage.area')[$mortgage->area],
            $mortgage->nationality,
        ];
    }
}
