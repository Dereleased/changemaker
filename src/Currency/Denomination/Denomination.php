<?php

declare(strict_types=1);

namespace Changemaker\Currency\Denomination;

use Changemaker\Currency\Unit\UnitInterface;
use Changemaker\Currency\Denomination\Format\FormatInterface;

class Denomination implements DenominationInterface
{
    /** @var int */
    private $value;

    /** @var UnitInterface */
    private $currencyUnit;

    /** @var FormatInterface */
    private $currencyFormat;

    public function __construct(int $value, UnitInterface $currencyUnit, FormatInterface $currencyFormat)
    {
        $this->value          = $value;
        $this->currencyUnit   = $currencyUnit;
        $this->currencyFormat = $currencyFormat;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getCurrencyUnit(): UnitInterface
    {
        return $this->currencyUnit;
    }

    public function getcurrencyFormat(): FormatInterface
    {
        return $this->currencyFormat;
    }
}