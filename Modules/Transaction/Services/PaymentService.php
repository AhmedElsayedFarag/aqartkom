<?php

namespace Modules\Transaction\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Transaction\DTO\PaymentDTO;
use Modules\Transaction\Entities\Transaction;
use Illuminate\Support\Str;
use Modules\Transaction\Services\Handlers\BasePaymentHandler;

class PaymentService
{
    public function __construct()
    {
    }
    private function getToken()
    {
        return \config('transaction.mode') == 'sandbox' ? \config('transaction.sandbox.token') : \config('transaction.live.token');
    }
    private function getUrl()
    {
        return \config('transaction.mode') == 'sandbox' ? \config('transaction.sandbox.url') : \config('transaction.live.url');
    }
    public function initiate(float $amount)
    {
        $response =  Http::withToken($this->getToken())
            ->post($this->getUrl() . '/v2/InitiatePayment', [
                "InvoiceAmount" => $amount,
                "CurrencyIso" => "SAR",
            ]);
        if (!$response->ok())
            throw new \Exception('Error in initiating payment');
        $response = $response->json();
        if ($response['IsSuccess'] != true) {
            throw new \Exception($response['Message']);
        }

        return
            \collect($response['Data']['PaymentMethods'])->filter(function ($item) {
                return $item['PaymentCurrencyIso'] == 'SAR' && $item['PaymentMethodId'] != 13;
            })->map(function ($item) {
                return [
                    'id' => $item['PaymentMethodId'],
                    'name' => $item['PaymentMethodAr'],
                    'logo' => $item['ImageUrl'],
                ];
            })->values()->toArray();
    }
    public function createLink(PaymentDTO $dto): array
    {

        return DB::transaction(function () use ($dto) {
            $coupon = $dto->paymentAmountDTO->coupon;
            if ($coupon) {
                $coupon->current_usage++;
                if ($coupon->current_usage == $coupon->max_usage) {
                    $coupon->is_active = false;
                }
                $coupon->save();
            }
            $transaction = Transaction::create($dto->toArray());
            if ($dto->paidPackage) {
                $transaction->update([
                    'paid_package_id' => $dto->paidPackage->id,
                    'paid_package_type' => get_class($dto->paidPackage),
                ]);
            }
            if ($transaction->amount == 0) {
                $transaction->update([
                    'status' => 'approved',
                ]);
                $handler = BasePaymentHandler::make($transaction->service_type);
                $handler->handle($transaction);
                return [
                    'paid' => true,
                    'link' => '',
                ];
            }
            $response =  Http::withToken($this->getToken())
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post(
                    $this->getUrl() . 'v2/ExecutePayment',
                    $this->preparePayment($dto, $transaction->uuid)
                );

            if (!$response->ok())
                throw new \Exception('Error in executing payment');
            $response = $response->json();
            if ($response['IsSuccess'] != true) {
                throw new \Exception($response['Message']);
            }
            $transaction->update([
                'init_data' => json_encode($response),
                'transaction_id' => $response['Data']['InvoiceId'],
            ]);
            return [
                'paid' => false,
                'link' => $response['Data']['PaymentURL'],
            ];
            // return $response;
        });
    }
    public function checkPayment(string $paymentID, string $id): bool
    {
        // GetPaymentStatus
        $response =  Http::withToken($this->getToken())
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->getUrl() . 'v2/getPaymentStatus', [
                "Key" => $paymentID,
                "KeyType" => "PaymentId",
            ]);

        if (!$response->ok())
            throw new \Exception('Error in executing payment');
        $response = $response->json();
        if ($response['IsSuccess'] != true) {
            throw new \Exception($response['Message']);
        }
        $transaction = Transaction::where('uuid', $response['Data']['UserDefinedField'])->first();
        if (!$transaction)
            throw new \Exception('Transaction not found');
        $isPaid = $response['Data']['InvoiceStatus'] == 'Paid';
        DB::transaction(function () use ($response, $transaction, $paymentID, $id, $isPaid) {
            $transaction->update([
                'status' => $isPaid ? 'approved' : 'canceled',
                'inquiry_data' => json_encode($response),
                'response_data' => json_encode([
                    'paymentId' => $paymentID,
                    'Id' => $id,
                ]),
            ]);
            if ($isPaid) {

                $handler = BasePaymentHandler::make($transaction->service_type);
                $handler->handle($transaction);
            }
        });
        //executing handler
        return $isPaid;
    }
    public function preparePayment(PaymentDTO $dto, string $uuid)
    {
        return [

            "CustomerName" => $dto->customerName,
            "InvoiceValue" => (float)$dto->paymentAmountDTO->calculateTotal(),
            "DisplayCurrencyIso" => "SAR",
            "PaymentMethodId" => $dto->paymentMethodId,
            "CallBackUrl" => route('success-payment'),
            "ErrorUrl" => route('failed-payment'),
            "Language" => "AR",
            "UserDefinedField" => $uuid,
            'MobileCountryCode' => '+966',
            "CustomerMobile" => \str_replace('+966', '', $dto->customerPhone),
            'CustomerEmail' => $dto->customerEmail,
            // "InvoiceItems" => [
            //     [
            //         "ItemName" => $dto->paymentType,
            //         "Quantity" => (float)1,
            //         "UnitPrice" => $dto->amount,
            //     ]
            // ],

        ];
    }
}