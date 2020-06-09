<?php

declare(strict_types=1);

namespace Changemaker;

use Changemaker\Currency\CurrencyInterface;

class Calculator
{
    /** @var CurrencyInterface */
    private $currency;

    public function __construct(CurrencyInterface $currency)
    {
        $this->currency = $currency;
    }

    public function makeChange($due, $paid): array
    {
        
    }
}