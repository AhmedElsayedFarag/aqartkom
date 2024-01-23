<?php

namespace Modules\Transaction\Services\Handlers;

use Illuminate\Database\Eloquent\Model;
use Modules\Ad\Services\AdService;
use Modules\Transaction\Contracts\IPaymentHandler;
use Modules\Transaction\Entities\Transaction;

class AdFeatureHandler implements IPaymentHandler
{
    public function handle(Transaction $transaction)
    {
        $adService = new AdService();
        $adService->addFeature($transaction->transactionable, $transaction->paidPackage->days);
    }
}
