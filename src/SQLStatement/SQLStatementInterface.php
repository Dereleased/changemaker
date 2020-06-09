<?php

namespace Changemaker\SQLStatement;

interface SQLStatementInterface
{
    public function getQuery(): string;
    public function getParams(): array;
}