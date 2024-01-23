<?php

namespace Modules\Transaction\Services\Handlers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Ad\Services\AdService;
use Modules\Subscription\Entities\SubscriptionFeature;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Transaction\Contracts\IPaymentHandler;
use Modules\Transaction\Entities\Transaction;

class SubscriptionHandler implements IPaymentHandler
{
    public function handle(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {
            if ($transaction->status != "approved")
                return;
            $user = $transaction->transactionable;
            $package = $transaction->paidPackage;
            $activeSubscription  = SubscriptionService::getActiveSubscription($transaction->user_id);
            if ($activeSubscription) {
                $activeSubscription->update([
                    'status' => 'expired',
                ]);
            }
            $subscription = $user->subscriptions()->create([
                'package_id' => $package->id,
                'package_name' => $package->title,
                'user_name' => $user->name,
                'user_phone' => $user->phone,
                'status' => 'approved',
                'start_at' => now(),
                'end_at' => now()->addMonths($package->months),
            ]);
            SubscriptionFeature::insert($this->format($subscription->id, $package->features));
        });
    }
    public function format(int $subscriptionID, $features)
    {
        $data = [];
        foreach ($features as $feature) {
            $data[] = [
                'subscription_id' => $subscriptionID,
                'feature_title' => $feature->title,
                'feature_type' => $feature->type,
                'feature_value' => json_encode($feature->value),
                'package_feature_id' => $feature->id,
                'start_count' => $feature->value['count'],
                'remaining_count' => $feature->value['count'],
            ];
        }
        return $data;
    }
}
