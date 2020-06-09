<?php

namespace Changemaker\Exception;

class InvalidCurrencyDefinitionException extends \Exception
{
    public const ERROR_BAD_PARENT_RELATIONSHIP = 1;

    public function __construct(int $code)
    {
        parent::__construct("Invalid Currency Definition", $code);
    }
}