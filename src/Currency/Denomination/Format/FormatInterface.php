<?php

namespace Changemaker\Currency\Denomination\Format;

use Changemaker\Generic\SingularAndPluralNameInterface;

interface FormatInterface extends SingularAndPluralNameInterface
{
    public function getId(): int;
    public function isPhysical(): bool;
}