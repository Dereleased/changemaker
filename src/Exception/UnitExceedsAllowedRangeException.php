<?php

namespace Changemaker\Exception;

use Changemaker\Currency\Unit\UnitInterface;

class UnitExceedsAllowedRangeException extends \Exception
{
    /** @var UnitInterface */
    protected $unit;

    /** @var int */
    protected $value;

    public function __construct(UnitInterface $unit, int $value)
    {
        $this->unit = $unit;
        $this->value = $value;

        parent::__construct(sprintf("Unit '%s' of currency '%s' is in excess of allowed range (1 to %d) with a value of %d",
            $unit->getNameSingular(),
            $unit->getCurrency()->getName(),
            $unit->getParentRatio() - 1,
            $value
        ));
    }
}