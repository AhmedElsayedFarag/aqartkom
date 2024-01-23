<?php

namespace Modules\Transaction\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Entities\Ad;
use Modules\Transaction\Entities\Transaction;

class TransactionController extends Controller
{
    public function __invoke(Request $request)
    {
        $transaction = Transaction::find($request->get('id'));
        if ($transaction->transactionable_type == Ad::class) {
            $transaction->update([
                'status' => 'approved'
            ]);
            $transaction->transactionable->is_featured = true;
            $transaction->transactionable->featured_at = now();
            $transaction->transactionable->featured_expires_at = now()->addDays(15);
            $transaction->transactionable->save();
        }
    }
}