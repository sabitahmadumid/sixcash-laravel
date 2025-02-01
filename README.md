# Unofficial Laravel SDK wrapper for 6Cash payment gateway script

# SixCash Laravel Package

[![Latest Version](https://img.shields.io/packagist/v/sabitahmadumid/sixcash-laravel.svg)](https://packagist.org/packages/sabitahmadumid/sixcash-laravel)
[![License](https://img.shields.io/packagist/l/sabitahmadumid/sixcash-laravel.svg)](https://packagist.org/packages/sabitahmadumid/sixcash-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/sabitahmadumid/sixcash-laravel.svg)](https://packagist.org/packages/sabitahmadumid/sixcash-laravel)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

A Laravel package for seamless integration with the **SixCash Payment Gateway**. This package provides an easy-to-use interface for creating payment orders and verifying transactions.


---

## Features

- 💳 **Create Payment Orders**: Initiate payments and redirect users to the SixCash payment page.
- ✅ **Verify Payments**: Verify transaction status using the transaction ID.
- 🛡 **Type Safety**: Built with TypeScript-like type safety for robust error handling.
- 🚦 **Error Handling**: Custom exceptions for merchant not found, payment verification failures, and more.
- 🔒 **Input Validation**: Automatically validates input parameters.
- 📦 **Laravel Integration**: Fully integrated with Laravel's service container and facades.

---

## Installation

You can install the package via composer:

```bash
composer require sabitahmadumid/sixcash-laravel
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="sixcash-laravel-config"
```

This is the contents of the published config file:

```php
return [
    'base_url' => env('SIXCASH_BASE_URL', 'https://api.sixcash.com'),
    'public_key' => env('SIXCASH_PUBLIC_KEY'),
    'secret_key' => env('SIXCASH_SECRET_KEY'),
    'merchant_number' => env('SIXCASH_MERCHANT_NUMBER'),
];
```

Add the following environment variables to your `.env` file:

```dotenv
SIXCASH_BASE_URL=https://api.sixcash.com
SIXCASH_PUBLIC_KEY=your_public_key
SIXCASH_SECRET_KEY=your_secret_key
SIXCASH_MERCHANT_NUMBER=your_merchant_number
```

## Usage

### Initialize the Package
The package is automatically registered via the service provider. You can start using it immediately.

### Create a Payment Order

```php
use SabitAhmad\SixCash\Facades\SixCash;

try {
    $amount = 100.50; // Payment amount
    $callbackUrl = route('payment.callback'); // Callback URL after payment
    $redirectUrl = SixCash::createPaymentOrder($amount, $callbackUrl);

    // Redirect the user to the payment page
    return redirect()->away($redirectUrl);
} catch (\SabitAhmad\SixCash\Exceptions\MerchantNotFoundException $e) {
    return back()->withErrors(['error' => 'Merchant not found']);
} catch (\Exception $e) {
    return back()->withErrors(['error' => $e->getMessage()]);
}
```

### Verify Payment

```php
use SabitAhmad\SixCash\Facades\SixCash;

try {
    $transactionId = request('transaction_id'); // Get transaction ID from request
    $payment = SixCash::verifyPayment($transactionId);

    if ($payment['is_paid']) {
        // Handle successful payment
        return response()->json(['message' => 'Payment successful']);
    } else {
        // Handle pending or failed payment
        return response()->json(['message' => 'Payment not completed']);
    }
} catch (\SabitAhmad\SixCash\Exceptions\PaymentVerificationException $e) {
    return response()->json(['error' => $e->getMessage()], 422);
}
```

### Payment Record Structure

```php
[
'id' => 'string', // Payment ID
'merchant_id' => 'int', // Merchant ID
'user_id' => 'int', // User ID
'transaction_id' => 'string', // Transaction ID
'amount' => 'float', // Payment amount
'is_paid' => 'bool', // Payment status
'expires_at' => 'Carbon', // Expiration date
'created_at' => 'Carbon' // Creation date
]
```
## Error Handling

```php
try {
    $redirectUrl = SixCash::createPaymentOrder(100, route('payment.callback'));
} catch (\SabitAhmad\SixCash\Exceptions\MerchantNotFoundException $e) {
    // Handle merchant not found
} catch (\SabitAhmad\SixCash\Exceptions\PaymentVerificationException $e) {
    // Handle verification failure
} catch (\Exception $e) {
    // Handle other errors
}
```



## Testing
To run the tests, use the following command:

```bash
composer test
```


## Support

For any issues, feature requests, or development assistance, feel free to contact me on Discord:
Username: **xcal_ibur**

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Sabit Ahmad](https://github.com/sabitahmadumid)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
