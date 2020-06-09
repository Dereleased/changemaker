<?php

declare(strict_types=1);

namespace Changemaker\SQLStatement;

class SelectCurrencyUnitDenominations implements SQLStatementInterface
{
    protected $currency_unit_id;

    public function __construct(int $currency_unit_id)
    {
        $this->currency_unit_id = $currency_unit_id;
    }

    public function getQuery(): string
    {
        return "SELECT
            id,
            currency_unit_id,
            value,
            currency_format_id,
            name_singular,
            name_plural
        FROM
            currency_unit_denom
        WHERE
            currency_unit_id = ?
        ORDER BY
            value DESC
        ";
    }

    public function getParams(): array
    {
        return [ $this->currency_unit_id ];
    }
}