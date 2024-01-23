<?php

namespace Modules\Transaction\Services\Handlers;

use Illuminate\Database\Eloquent\Model;
use Modules\Ad\Services\AdService;
use Modules\Transaction\Contracts\IPaymentHandler;
use Modules\Transaction\Entities\Transaction;

class AdLicensingHandler implements IPaymentHandler
{
    public function handle(Transaction $transaction)
    {
        if ($transaction->status == 'approved')
            $transaction->transactionable->update([
                'status' => 'approved',
                'license_cost' => $transaction->amount,
            ]);
        else
            $transaction->transactionable->update([
                'status' => 'cancelled',
            ]);
    }
}
