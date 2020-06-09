<?php

declare(strict_types=1);

namespace Changemaker\Generic;

trait SingularAndPluralNameTrait {
    /** @var string */
    protected $name_singular;

    /** @var string */
    protected $name_plural;

    public function getNameSingular(): string
    {
        return $this->name_singular;
    }

    public function getNamePlural(): string
    {
        return $this->name_plural;
    }

    protected function setNames(string $singular, string $plural): void
    {
        $this->name_singular = $singular;
        $this->name_plural   = $plural;
    }

    public function getName(int $quantity): string
    {
        return $quantity === 1 ? $this->name_singular : $this->name_plural;
    }
}