<?php

declare(strict_types=1);

namespace Changemaker\Currency\Denomination\Format;

use Changemaker\Generic\SingularAndPluralNameTrait;

class Format implements FormatInterface
{
    use SingularAndPluralNameTrait;

    /** @var int */
    protected $id;

    /** @var bool */
    protected $is_physical;

    public function __construct(int $id, string $name_singular, string $name_plural, bool $is_physical)
    {
        $this->id          = $id;
        $this->is_physical = $is_physical;

        $this->setNames($name_singular, $name_plural);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isPhysical(): bool
    {
        return $this->is_physical;
    }
}