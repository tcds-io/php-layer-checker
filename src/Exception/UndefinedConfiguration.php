<?php

declare(strict_types=1);

namespace Tcds\Io\Player\Exception;

use Override;
use Tcds\Io\Player\Formatter;

class UndefinedConfiguration extends PlayerException
{
    public function __construct(public readonly string $config, public readonly string $module)
    {
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    #[Override] public function output(): array
    {
        return Formatter::error("Module `$this->module` extends non-existing module/preset `$this->config`");
    }
}
