<?php

declare(strict_types=1);

namespace Changemaker;

use Changemaker\Currency\CurrencyInterface;
use Changemaker\Change\ChangeUnit;

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

        $amount = preg_replace("/[^{$allowable}]/", "", $due);
        $paid   = preg_replace("/[^{$allowable}]/", "", $paid);

        preg_match("/{$format}/", $amount, $amount_units);
        preg_match("/{$format}/", $paid, $paid_units);

        $amount_total = $paid_total = 0;

        for ($i = 1; $i <= $position; ++$i) {
            $amount_current = (int)($amount_units[$i] ?? 0) * $ratio;
            $paid_current   = (int)($paid_units[$i] ?? 0)   * $ratio;

            $amount_total += $amount_current;
            $paid_total   += $paid_current;

            if ($i < $position) {
                $ratio /= $unitPos[$i + 1]->getParentRatio();
            }
        }

        $difference = $paid_total - $amount_total;

        $changeUnits = [];

        foreach (array_reverse($unitPos) as $unit) {
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