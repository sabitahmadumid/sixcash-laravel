<?php

namespace SabitAhmad\SixCash\Exceptions;

use Exception;

class PaymentVerificationException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 422);
    }
}
