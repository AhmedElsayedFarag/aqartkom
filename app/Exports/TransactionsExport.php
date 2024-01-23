<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Transaction\Entities\Transaction;

class TransactionsExport implements FromQuery, WithHeadings, WithMapping
{

    use Exportable;
    public function __construct(
        private ?string $search = null,
        private ?string $status = null,
        private ?string $date = null,
    ) {
    }
    public function headings(): array
    {

        return [
            __('validation.attributes.name'),
            __('validation.attributes.phone'),
            __('validation.attributes.subtotal'),
            __('validation.attributes.vat'),
            __('validation.attributes.discount'),
            __('validation.attributes.price'),
            __('validation.attributes.status'),
            __('validation.attributes.service_type'),
        ];
    }
    public function query()
    {
        return Transaction::query()
            ->search($this->search)
            ->statusFilter($this->status)
            ->dateRange($this->date)
            ->latest()
            ->limit(2000);
    }
    /**
     * @var Invoice $invoice
     */
    public function map($transaction): array
    {
        return [
            $transaction->customer_name,
            $transaction->customer_phone,
            $transaction->subtotal_before_discount,
            $transaction->vat,
            $transaction->coupon_discount ?? 0,
            $transaction->amount,
            __('admin.payment_statuses')[$transaction->status],
            __('admin.service_types')[$transaction->service_type->value]
        ];
    }
}
