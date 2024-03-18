<?php

declare(strict_types=1);

namespace Tcds\Io\Player\Exception;

use Override;
use Tcds\Io\Player\Formatter;

class UnacceptableUsages extends PlayerException
{
    /**
     * @param array<string, array<string>> $leaking
     */
    public function __construct(public readonly array $leaking)
    {
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    #[Override] public function output(): array
    {
        $separator = Formatter::line('', '-');
        $lines = [];

        foreach ($this->leaking as $class => $imports) {
            $lines[] = $separator;
            $lines[] = "<info>$class</info>";
            $lines[] = $separator;
            $lines[] = join(PHP_EOL, $imports);
            $lines[] = $separator;
            $lines[] = '';
        }

        return array_merge(
            $lines,
            Formatter::error(
                sprintf(
                    'Found %s unacceptable imports in %s classes',
                    array_reduce($this->leaking, fn(int $reduced, array $imports) => $reduced + count($imports), 0),
                    count($this->leaking),
                ),
            ),
        );
    }
}
