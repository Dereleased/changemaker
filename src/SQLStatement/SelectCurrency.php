<?php

declare(strict_types=1);

namespace Changemaker\SQLStatement;

class SelectCurrency implements SQLStatementInterface
{
    public const CRITERION_CODE = 1;
    public const CRITERION_ID   = 2;

    protected const CRITERION_MAP = [
        self::CRITERION_CODE => 'code',
        self::CRITERION_ID   => 'id',
    ];

    protected $criterion;

    protected $field;

    public function __construct($criterion, int $field = self::CRITERION_CODE)
    {
        if (!isset(self::CRITERION_MAP[$field])) {
            throw new \InvalidArgumentException("Bad argument '{$field}' for criterion code");
        }

        $this->criterion = $criterion;
        $this->field     = self::CRITERION_MAP[$field];
    }

    public function getQuery(): string
    {
        return "SELECT
            id,
            code,
            symbol,
            name
        FROM
            currency
        WHERE
            {$this->field} = ?
        ";
    }

    public function getParams(): array
    {
        return [ $this->criterion ];
    }
}