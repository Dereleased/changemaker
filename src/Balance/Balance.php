<?php

declare(strict_types=1);

namespace Changemaker\Balance;

use Changemaker\Currency\CurrencyInterface;

class Balance implements BalanceInterface
{
    /** @var BalanceUnitInterface[] */
    protected $balanceUnits = [];

    /** @var CurrencyInterface */
    protected $currency;

    /**
     * @param BalanceUnit[] $balanceUnits
     */
    public function __construct(CurrencyInterface $currency, array $balanceUnits = [])
    {
        $this->currency = $currency;
        $this->addBalanceUnits($balanceUnits);
    }

    public function addBalanceUnit(BalanceUnitInterface $balanceUnit): void
    {
        $this->balanceUnits[] = $balanceUnit;
    }

    /**
     * @param BalanceUnit[] $balanceUnits
     */
    public function addBalanceUnits(array $balanceUnits): void
    {
        foreach ($balanceUnits as $bu) {
            if ($bu instanceof BalanceUnitInterface) {
                $this->addBalanceUnit($bu);
            }
        }
    }

    /**
     * @return BalanceUnit[]
     */
    public function getBalanceUnits(): array
    {
        return $this->balanceUnits;
    }

    public function __toString(): string
    {
        $units_by_name = [];
        /** @var BalanceUnitInterface $bu */
        foreach ($this->balanceUnits as $bu) {
            $units_by_name[$bu->getUnit()->getNameSingular()] = $bu;
        }

        $balance_due_string = "";

        $unit = $this->currency->getUnit();
        do {
            if (isset($units_by_name[$unit->getNameSingular()])) {
                if ($unit->hasParentUnit()) {
                    $balance_due_string .= $unit->getSeparatorMask();
                } else {
                    $balance_due_string .= $this->currency->getSymbol();
                }

                $balance_due_string .= (string)$units_by_name[$unit->getNameSingular()]->getQuantity();
            }
        } while ($unit->hasChildUnit() && ($unit = $unit->getChildUnit()));

        return $balance_due_string;
    }
}