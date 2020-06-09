<?php

declare(strict_types=1);

namespace Changemaker\Change;

use Changemaker\Currency\Denomination\DenominationInterface;

class ChangeUnit implements ChangeUnitInterface
{
    /** @var DenominationInterface */
    protected $denomination;

    /** @var int */
    protected $count;

    public function __construct(DenominationInterface $denomination, int $count)
    {
        $this->denomination = $denomination;
        $this->count        = $count;
    }

    public function getDenomination(): DenominationInterface
    {
        return $this->denomination;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function __toString(): string
    {
        return sprintf("%d x %s", $this->count, $this->denomination->getName($this->count));
    }
}