<?php

namespace Changemaker\Generic;

interface SingularAndPluralNameInterface
{
    public function getNameSingular(): string;
    public function getNamePlural(): string;
    public function getName(int $quantity): string;
}