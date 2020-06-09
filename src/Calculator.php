<?php

declare(strict_types=1);

namespace Changemaker;

use Changemaker\Currency\CurrencyInterface;
use Changemaker\Currency\Unit\UnitInterface;
use Changemaker\Change\ChangeUnit;
use Changemaker\Exception\{ UnitExceedsAllowedRangeException, BalanceNotSatisfiedException };
use Changemaker\Balance\{ Balance, BalanceInterface, BalanceUnit };

class Calculator
{
    /** @var CurrencyInterface */
    protected $currency;

    /** @var string */
    protected $format;

    /** @var string */
    protected $allowable;

    /** @var int */
    protected $ratio;

    /** @var UnitInterface[] */
    protected $unitPositions = [];

    /** @var int */
    protected $maxPosition;

    public function __construct(CurrencyInterface $currency)
    {
        $this->currency = $currency;

        $this->prepareCalculator();
    }

    protected function prepareCalculator(): void
    {
        $format    = "(\d+)";
        $unit      = $this->currency->getUnit();
        $allowable = "0-9";
        $unitPos   = [ $position = 1 => $unit ];
        $ratio     = 1;

        while ($unit->hasChildUnit()) {
            $unit       = $unit->getChildUnit();
            $allowable .= $unit->getSeparatorMask();
            $format    .= "(?:\Q{$unit->getSeparatorMask()}\E(\d+))?";
            $ratio     *= $unit->getParentRatio();
            $unitPos[++$position] = $unit;
        }

        $this->format    = $format;
        $this->allowable = $allowable;
        $this->ratio     = $ratio;

        $this->unitPositions = $unitPos;
        $this->maxPosition   = $position;
    }

    protected function getUnitAmounts($amount): array
    {
        $amount = preg_replace("/[^{$this->allowable}]/", "", (string)$amount);

        preg_match("/{$this->format}/", $amount, $amount_units);

        return $amount_units;
    }

    protected function getAmountInTermsOfSmallestUnit($amount): int
    {
        $ratio = $this->ratio;

        $amount_units = $this->getUnitAmounts($amount);
        $amount_total = 0;

        for ($i = 1, $ratio = $this->ratio; $i <= $this->maxPosition; ++$i) {
            $amount_current = (int)($amount_units[$i] ?? 0);
            $unit_current   = $this->unitPositions[$i];
            if ($unit_current->hasParentUnit() && $amount_current >= $unit_current->getParentRatio()) {
                throw new UnitExceedsAllowedRangeException($unit_current, $amount_current);
            }

            $amount_current *= $ratio;
            $amount_total   += $amount_current;

            if ($i < $this->maxPosition) {
                $ratio /= $this->unitPositions[$i + 1]->getParentRatio();
            }
        }

        return $amount_total;
    }

    protected function createBalanceFromSmallestUnit(int $difference): BalanceInterface
    {
        $balanceDueUnits = [];
        $difference      = abs($difference);

        foreach (array_reverse($this->unitPositions) as $unit) {
            $current_unit_amount = $difference;
            $ratio               = 1;

            if ($unit->hasParentUnit()) {
                $ratio               = $unit->getParentRatio();
                $current_unit_amount = $difference % $ratio;
                $difference         -= $current_unit_amount;
            }

            if ($current_unit_amount > 0) {
                $balanceDueUnits[] = new BalanceUnit($unit, $current_unit_amount);
            }

            if ($ratio > 1) {
                $difference /= $ratio;
            }
        }

        return new Balance($this->currency, array_reverse($balanceDueUnits));
    }

    /**
     * @param mixed $due
     * @param mixed $paid
     * @return ChangeUnitInterface[]
     * @throws BalanceNotSatisfiedException
     */
    public function makeChange($due, $paid): array
    {
        $amount_due  = $this->getAmountInTermsOfSmallestUnit($due);
        $amount_paid = $this->getAmountInTermsOfSmallestUnit($paid);
        
        $difference = $amount_paid - $amount_due;

        if ($difference < 0) {
            $balance = $this->createBalanceFromSmallestUnit($difference);
            throw new BalanceNotSatisfiedException($balance);
        }

        $changeUnits = [];

        foreach (array_reverse($this->unitPositions) as $unit) {
            $current_unit_change = [];
            $current_unit_amount = $difference;
            $ratio = 1;

            if ($unit->hasParentUnit()) {
                $ratio               = $unit->getParentRatio();
                $current_unit_amount = $difference % $ratio;
                $difference         -= $current_unit_amount;
            }

            foreach ($unit->getDenominations() as $denom) {
                $denom_value = $denom->getValue();

                if ($current_unit_amount < $denom_value) {
                    continue;
                }

                $next_unit_difference  = $current_unit_amount % $denom_value;
                $current_unit_amount  -= $next_unit_difference;
                $current_unit_quantity = $current_unit_amount / $denom_value;

                $current_unit_change[] = new ChangeUnit($denom, $current_unit_quantity);

                $current_unit_amount = $next_unit_difference;
            }

            if ($ratio > 1) {
                $difference /= $ratio;
            }

            $changeUnits = array_merge($current_unit_change, $changeUnits);
        }

        return $changeUnits;
    }
}