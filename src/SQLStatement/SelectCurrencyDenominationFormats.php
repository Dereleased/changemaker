<?php

declare(strict_types=1);

namespace Changemaker\SQLStatement;

class SelectCurrencyDenominationFormats implements SQLStatementInterface
{
    public function __construct() {}

    public function getParams(): array
    {
        return [];
    }

    public function getQuery(): string
    {
        return "SELECT
            id,
            name,
            is_physical
        FROM
            currency_format
        WHERE
            1
        ";
    }
}