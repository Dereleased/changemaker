<?php

declare(strict_types=1);

namespace Changemaker\Currency\Unit;

use Changemaker\Currency\CurrencyInterface;
use Changemaker\Currency\Denomination\DenominationInterface;
use Changemaker\Generic\SingularAndPluralNameTrait;

class Unit implements UnitInterface
{
    use SingularAndPluralNameTrait;

    /** @var int */
    private $id;

    /** @var CurrencyInterface */
    private $currency;

    /** @var ?UnitInterface */
    private $parentUnit = null;

    /** @var int|null */
    private $parent_unit_ratio = null;

    /** @var ?UnitInterface */
    private $childUnit = null;

    /** @var string|null */
    private $separator_symbol_mask = null;

    /** @var DenominationInterface[] */
    private $denominations = [];

    /** @var bool */
    private $denom_sorted = false;

    public function __construct(
        CurrencyInterface $currency,
        string $name_singular,
        string $name_plural,
        ?UnitInterface $parentUnit     = null,
        ?int $parent_unit_ratio        = null,
        ?string $separator_symbol_mask = null,
        ?int $id                       = null

    )
    {
        $this->id                    = $id;
        $this->currency              = $currency;
        $this->parentUnit            = $parentUnit;
        $this->parent_unit_ratio     = $parent_unit_ratio;
        $this->separator_symbol_mask = $separator_symbol_mask;

        $this->setNames($name_singular, $name_plural);
    }

    public function getCurrency(): CurrencyInterface
    {
        return $this->currency;
    }

    public function hasParentUnit(): bool
    {
        return $this->parentUnit !== null;
    }

    public function getParentUnit(): ?UnitInterface
    {
        return $this->parentUnit;
    }

    public function getParentRatio(): ?int
    {
        return $this->parent_unit_ratio;
    }

    public function setChildUnit(UnitInterface $child): void
    {
        $this->childUnit = $child;
    }

    public function hasChildUnit(): bool
    {
        return $this->childUnit !== null;
    }

    public function getChildUnit(): ?UnitInterface
    {
        return $this->childUnit;
    }

    public function getSeparatorMask(): ?string
    {
        return $this->separator_symbol_mask;
    }

    public function addDenomination(DenominationInterface $denomination): void
    {
        $this->denom_sorted = false;

        $this->denominations[$denomination->getValue()] = $denomination;
    }

    /**
     * @param DenominationInterface[] $denominations
     */
    public function addDenominations(array $denominations): void
    {
        foreach ($denominations as $denomination) {
            $this->addDenomination($denomination);
        }
    }

    /**
     * @return DenominationInterface[]
     */
    public function getDenominations(): array
    {
        if (!$this->denom_sorted) {
            krsort($this->denominations);
            $this->denom_sorted = true;
        }

        return $this->denominations;
    }
}