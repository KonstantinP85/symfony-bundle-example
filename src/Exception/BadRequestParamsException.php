<?php

namespace St\AbstractService\Exception;

class BadRequestParamsException extends \Exception
{
    public function __construct(array $arrayOfMessage)
    {
        parent::__construct(json_encode($arrayOfMessage) ?? '', 400);
    }
}