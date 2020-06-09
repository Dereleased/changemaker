<?php

declare(strict_types=1);

namespace Changemaker;

use Changemaker\Currency\UnitInterface;

class Currency implements CurrencyInterface
{
    /** @var int */
    private $id;

    /** @var string */
    private $symbol;

    /** @var string */
    private $abbr;

    /** @var string */
    private $name;

    /** @var UnitInterface[] */
    private $units = [];

    public function __construct(string $symbol, string $abbr, string $name, array $units, int $id = null)
    {
        $this->id = $id;
        $this->symbol = $symbol;
        $this->abbr = $abbr;
        $this->name = $name;

        foreach ($units as $unit) {
            if (!($unit instanceof UnitInterface)) {
                continue;
            }

            $this->units[] = $unit;
        }
    }
}