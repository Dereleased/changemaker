<?php

namespace Changemaker\Balance;

interface BalanceInterface
{
    public function addBalanceUnit(BalanceUnitInterface $balanceUnit): void;
    
    /**
     * @param BalanceUnitInterface[] $balanceUnit
     */
    public function addBalanceUnits(array $balanceUnit): void;

    /**
     * @return BalanceUnitInterface[]
     */
    public function getBalanceUnits(): array;

    public function __toString(): string;
}