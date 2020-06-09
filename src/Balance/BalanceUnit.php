<?php

declare(strict_types=1);

namespace Changemaker\Balance;

use Changemaker\Currency\Unit\UnitInterface;

class BalanceUnit implements BalanceUnitInterface
{
    /** @var UnitInterface */
    private $unit;

    /** @var int */
    private $quantity;

    public function __construct(UnitInterface $unit, int $quantity)
    {
        $this->unit     = $unit;
        $this->quantity = $quantity;
    }

    public function getUnit(): UnitInterface
    {
        return $this->unit;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function __toString(): string
    {
        if ($this->quantity === 0) {
            return "";
        }

        return sprintf("%d %s", $this->quantity, $this->unit->getName($this->quantity));
    }
}