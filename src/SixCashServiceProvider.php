<?php

namespace SabitAhmad\SixCash;

use SabitAhmad\SixCash\Commands\SixCashCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SixCashServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('sixcash-laravel')
            ->hasConfigFile()
            ->hasCommand(SixCashCommand::class);
    }

    public function registeringPackage(): void
    {
        $this->app->singleton('sixcash', function () {
            return new SixCash(
                config('sixcash.base_url'),
                config('sixcash.public_key'),
                config('sixcash.secret_key'),
                config('sixcash.merchant_number')
            );
        });
    }
}
