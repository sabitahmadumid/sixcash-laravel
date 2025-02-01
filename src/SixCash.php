<?php

namespace SabitAhmad\SixCash;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use SabitAhmad\SixCash\Exceptions\MerchantNotFoundException;

class SixCash {

    protected $baseUrl;
    protected $publicKey;
    protected $secretKey;
    protected $merchantNumber;


    public function __construct($baseUrl, $publicKey, $secretKey, $merchantNumber)
    {
        $this->baseUrl = $baseUrl;
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
        $this->merchantNumber = $merchantNumber;
    }

    /**
     * @throws Exception|MerchantNotFoundException
     */
    public function createPaymentOrder(float $amount, string $callbackUrl): string
    {
        $response = Http::post("{$this->baseUrl}/api/v1/create-payment-order", [
            'public_key' => $this->publicKey,
            'secret_key' => $this->secretKey,
            'merchant_number' => $this->merchantNumber,
            'amount' => number_format($amount, 2)
        ]);

        if ($response->json('status') === 'merchant_not_found') {
            throw new MerchantNotFoundException();
        }

        if ($response->json('status') === 'payment_created') {
            return $response->json('redirect_url') . '&callback=' . urlencode($callbackUrl);
        }

        throw new Exception('Payment creation failed: ' . $response->body());
    }

    public function verifyPayment(string $transactionId): array
    {
        $response = Http::post("{$this->baseUrl}/api/v1/payment-verification", [
            'public_key' => $this->publicKey,
            'secret_key' => $this->secretKey,
            'merchant_number' => $this->merchantNumber,
            'transaction_id' => $transactionId
        ]);

        if ($response->json('errors')) {
            throw new PaymentVerificationException(
                collect($response->json('errors'))->pluck('message')->implode(', ')
            );
        }

        return $this->formatPaymentRecord($response->json('payment_record'));
    }

    protected function formatPaymentRecord(array $record): array
    {
        return [
            'id' => $record['id'],
            'merchant_id' => $record['merchant_user_id'],
            'user_id' => $record['user_id'],
            'transaction_id' => $record['transaction_id'],
            'amount' => (float)$record['amount'],
            'is_paid' => (bool)$record['is_paid'],
            'expires_at' => Carbon::parse($record['expired_at']),
            'created_at' => Carbon::parse($record['created_at'])
        ];
    }

}
