<?php

namespace Changemaker\Currency\Unit;

use Changemaker\Currency\CurrencyInterface;
use Changemaker\Currency\Denomination\DenominationInterface;
use Changemaker\Generic\SingularAndPluralNameInterface;

interface UnitInterface extends SingularAndPluralNameInterface
{
    public function getId(): ?int;
    public function getCurrency(): CurrencyInterface;
    public function hasParentUnit(): bool;
    public function getParentUnit(): ?UnitInterface;
    public function getParentRatio(): ?int;
    public function getSeparatorMask(): ?string;
    public function setChildUnit(UnitInterface $unit): void;
    public function hasChildUnit(): bool;
    public function getChildUnit(): ?UnitInterface;
    
    public function addDenomination(DenominationInterface $denomination): void;
    
    /**
     * @param DenominationInterface[] $denominations
     */
    public function addDenominations(array $denominations): void;

    /**
     * @return DenominationInterface[]
     */
    public function getDenominations(): array;
}