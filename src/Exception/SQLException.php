<?php

namespace Changemaker\Exception;

class SQLException extends \Exception
{
    protected const EP_SQLSTATE    = 0;
    protected const EP_DRIVER_CODE = 1;
    protected const EP_DRIVER_MSG  = 2;

    protected $errorInfo = null;

    public function __construct(array $errorInfo)
    {
        $this->errorInfo = $errorInfo;

        parent::__construct(sprintf("An SQL Exception occurred, with SQLSTATE %5s; The driver responded [%s]: %s", ...$errorInfo), $errorInfo[self::EP_DRIVER_CODE]);
    }

    public function getErrorInfo(): array
    {
        return $this->errorInfo;
    }
}