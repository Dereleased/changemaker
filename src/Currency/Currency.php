<?php

declare(strict_types=1);

namespace Changemaker\Currency;

use Changemaker\Currency\Unit\UnitInterface;

class Currency implements CurrencyInterface
{
    /** @var int|null */
    private $id;

    /** @var string|null */
    private $symbol;

    /** @var string */
    private $abbr;

    /** @var string */
    private $name;

    /** @var UnitInterface */
    private $unit;

    public function __construct(string $symbol, string $abbr, string $name, UnitInterface $unit, int $id = null)
    {
        $this->id     = $id;
        $this->symbol = $symbol;
        $this->abbr   = $abbr;
        $this->name   = $name;
        $this->unit   = $unit;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function getUnit(): UnitInterface
    {
        return $this->unit;
    }
}