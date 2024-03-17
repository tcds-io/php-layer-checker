<?php

declare(strict_types=1);

namespace Tcds\Io\Player\Exception;

use Exception;

class UnacceptableUsagesException extends Exception
{
    /**
     * @param array<string, array<string>> $leaking
     */
    public function __construct(public readonly array $leaking)
    {
        parent::__construct();
    }
}
