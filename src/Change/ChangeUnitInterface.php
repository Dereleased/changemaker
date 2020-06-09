<?php

namespace Changemaker\Change;

use Changemaker\Currency\Denomination\DenominationInterface;

interface ChangeUnitInterface
{
    public function getDenomination(): DenominationInterface;
    public function getCount(): int;
    public function __toString(): string;
}