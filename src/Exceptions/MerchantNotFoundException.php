<?php

namespace SabitAhmad\SixCash\Exceptions;

use Exception;

class MerchantNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Merchant not found', 404);
    }
}
