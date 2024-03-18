<?php

declare(strict_types=1);

namespace Tcds\Io\Player\Exception;

use Override;
use Tcds\Io\Player\Formatter;

class InvalidModuleDirectory extends PlayerException
{
    public function __construct(private readonly string $directory, private readonly string $module)
    {
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    #[Override] public function output(): array
    {
        return Formatter::error("Directory `$this->module` does not exist in `$this->directory`");
    }
}
