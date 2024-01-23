<?php

namespace Modules\Transaction\Contracts;

use Illuminate\Database\Eloquent\Model;
use Modules\Transaction\Entities\Transaction;

interface IPaymentHandler
{
    public function handle(Transaction $transaction);
}
