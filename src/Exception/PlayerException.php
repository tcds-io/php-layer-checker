<?php

declare(strict_types=1);

namespace Tcds\Io\Player\Exception;

use Exception;

abstract class PlayerException extends Exception
{
    /**
     * @return array<string>
     */
    abstract public function output(): array;
}
