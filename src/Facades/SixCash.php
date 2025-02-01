<?php

namespace SabitAhmad\SixCash\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SabitAhmad\SixCash\SixCash
 */
class SixCash extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SabitAhmad\SixCash\SixCash::class;
    }
}
