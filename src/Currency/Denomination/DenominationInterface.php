<?php

namespace Changemaker\Currency\Denomination;

use Changemaker\Currency\Unit\UnitInterface;
use Changemaker\Currency\Denomination\Format\FormatInterface;

interface DenominationInterface
{
    public function getValue(): int;
    public function getCurrencyUnit(): UnitInterface;
    public function getCurrencyFormat(): FormatInterface;
    public function getId(): ?int;
    public function getName(int $quantity): string;
    public function getNameSingular(): ?string;
    public function getNamePlural(): ?string;
}