<?php

namespace Changemaker\Exception;

use Changemaker\Balance\BalanceInterface;

class BalanceNotSatisfiedException extends \Exception
{
    /** @var BalanceInterface */
    private $balance;

    public function __construct(BalanceInterface $balance)
    {
        $this->balance = $balance;
        parent::__construct("The following balance remains unsatisfied: " . (string)$balance);
    }

    public function getBalance(): BalanceInterface
    {
        return $this->balance;
    }
}