<?php

namespace Tcds\Io\Player\Exception;

use Exception;

class UnacceptableUsagesException extends Exception
{
    public function __construct(public readonly array $leaking)
    {
        parent::__construct();
    }
}
