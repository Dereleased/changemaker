<?php

namespace Changemaker\Balance;

use Changemaker\Currency\Unit\UnitInterface;

interface BalanceUnitInterface
{
    public function getUnit(): UnitInterface;
    public function getQuantity(): int;
    public function __toString(): string;
}