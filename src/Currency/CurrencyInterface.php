<?php

namespace Changemaker\Currency;

use Changemaker\Currency\Unit\UnitInterface;

interface CurrencyInterface
{
    public function getId(): ?int;
    public function getName(): string;
    public function getCode(): string;
    public function getSymbol(): string;

    public function getUnit(): UnitInterface;
}