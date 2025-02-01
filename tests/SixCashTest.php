<?php

use Illuminate\Support\Facades\Http;
use SabitAhmad\SixCash\Exceptions\MerchantNotFoundException;
use SabitAhmad\SixCash\SixCash;

it('creates payment order', function () {
    Http::fake([
        'api.sixcash.com/api/v1/create-payment-order' => Http::response([
            'status' => 'payment_created',
            'redirect_url' => 'https://payment.sixcash.com/checkout',
        ]),
    ]);

    $service = new SixCash(
        'https://api.sixcash.com',
        'test_pk',
        'test_sk',
        'test_merchant'
    );

    $url = $service->createPaymentOrder(100, 'https://callback.url');

    expect($url)->toBe('https://payment.sixcash.com/checkout&callback=https%3A%2F%2Fcallback.url');
});
it('throws merchant not found exception', function () {
    Http::fake([
        'api.sixcash.com/api/v1/create-payment-order' => Http::response([
            'status' => 'merchant_not_found',
        ]),
    ]);

    $service = new SixCash(
        'https://api.sixcash.com',
        'invalid_pk',
        'invalid_sk',
        'invalid_merchant'
    );

    $service->createPaymentOrder(100, 'https://callback.url');
})->throws(MerchantNotFoundException::class);
