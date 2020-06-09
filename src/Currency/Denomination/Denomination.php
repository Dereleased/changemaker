<?php

declare(strict_types=1);

namespace Changemaker\Currency\Denomination;

use Changemaker\Currency\Unit\UnitInterface;
use Changemaker\Currency\Denomination\Format\FormatInterface;

class Denomination implements DenominationInterface
{
    /** @var int|null */
    protected $id;

    /** @var int */
    protected $value;

    /** @var UnitInterface */
    protected $currencyUnit;

    /** @var FormatInterface */
    protected $currencyFormat;

    /** @var string|null */
    protected $name_singular = null;

    /** @var string|null */
    protected $name_plural = null;

    public function __construct(
        int $value,
        UnitInterface $currencyUnit,
        FormatInterface $currencyFormat,
        ?string $name_singular = null,
        ?string $name_plural = null,
        ?int $id = null
    )
    {
        $this->value          = $value;
        $this->currencyUnit   = $currencyUnit;
        $this->currencyFormat = $currencyFormat;
        $this->id             = $id;
        $this->name_singular  = $name_singular;
        $this->name_plural    = $name_plural;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getCurrencyUnit(): UnitInterface
    {
        return $this->currencyUnit;
    }

    public function getcurrencyFormat(): FormatInterface
    {
        return $this->currencyFormat;
    }

    public function getNameSingular(): ?string
    {
        return $this->name_singular;
    }

    public function getNamePlural(): ?string
    {
        return $this->name_plural;
    }

    public function getName(int $quantity): string
    {
        $type = "";
        if ($quantity === 1) {
            if ($this->name_singular !== null) {
                return $this->name_singular;
            }

            $type = $this->currencyFormat->getNameSingular();
        } else {
            if ($this->name_plural !== null) {
                return $this->name_plural;
            }

            $type = $this->currencyFormat->getNamePlural();
        }
        
        return sprintf("%d %s %s", $this->value, $this->currencyUnit->getNameSingular(), $type);
    }
}