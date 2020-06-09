<?php

declare(strict_types=1);

namespace Changemaker\SQLStatement;

class SelectCurrencyUnits implements SQLStatementInterface
{
    protected $currency_id;

    public function __construct(int $currency_id)
    {
        $this->currency_id = $currency_id;
    }

    public function getQuery(): string
    {
        return "SELECT
            id,
            parent_unit_id,
            parent_unit_ratio,
            name_singular,
            name_plural,
            separator_symbol_mask
        FROM
            currency_unit
        WHERE
            currency_id = ?
        ";
    }

    public function getParams(): array
    {
        return [ $this->currency_id ];
    }
}