<?php

namespace Changemaker\Currency\Unit;

use Changemaker\Currency\CurrencyInterface;
use Changemaker\Generic\SingularAndPluralNameInterface;

interface UnitInterface extends SingularAndPluralNameInterface
{
    public function getCurrency(): CurrencyInterface;
    public function hasParentUnit(): bool;
    public function getParentUnit(): ?UnitInterface;
    public function getParentRatio(): ?int;
    public function getSeparatorMask(): ?string;
    public function hasChildUnit(): bool;
    public function getChildUnit(): ?UnitInterface;
}