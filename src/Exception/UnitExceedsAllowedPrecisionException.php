<?php

declare(strict_types=1);

namespace Changemaker\Exception;

use Changemaker\Currency\Unit\UnitInterface;

class UnitExceedsAllowedPrecisionException extends \Exception
{
    public function __construct(UnitInterface $unit, int $precision, string $amount)
    {
        parent::__construct(sprintf("Unit '%s' of currency '%s' exceeds allowed precision of %d digits (received: %s)",
            $unit->getNameSingular(),
            $unit->getCurrency()->getName(),
            $precision,
            $amount
        ));
    }
}