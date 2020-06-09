<?php

declare(strict_types=1);

namespace Changemaker\Currency\Unit;

use Changemaker\Currency\CurrencyInterface;
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

    public function __construct(
        CurrencyInterface $currency,
        string $name_singular,
        string $name_plural,
        ?UnitInterface $parentUnit     = null,
        ?int $parent_unit_ratio        = null,
        ?string $separator_symbol_mask = null,
        ?UnitInterface $childUnit      = null,
        ?int $id                       = null

    )
    {
        $this->id                    = $id;
        $this->currency              = $currency;
        $this->parentUnit            = $parentUnit;
        $this->parent_unit_ratio     = $parent_unit_ratio;
        $this->separator_symbol_mask = $separator_symbol_mask;
        $this->childUnit             = $childUnit;

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

    public function hasChildUnit(): bool
    {
        return $this->childUnit === null;
    }

    public function getChildUnit(): ?UnitInterface
    {
        return $this->chlidUnit;
    }

    public function getSeparatorMask(): ?string
    {
        return $this->separator_symbol_mask;
    }
}