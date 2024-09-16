<?php

declare(strict_types=1);

namespace Tcds\Io\Player;

use Symfony\Component\Console\Terminal;

class Formatter
{
    public static function line(string $text, string $fill = ' '): string
    {
        $width = min((new Terminal())->getWidth(), 120);

        return str_pad($text, $width, $fill);
    }

    /**
     * @return array<string>
     */
    public static function success(string $text): array
    {
        return self::message(" [OK] $text", 'black', 'green');
    }

    /**
     * @return array<string>
     */
    public static function error(string $text): array
    {
        return self::message(" [ERROR] $text", 'white', 'red');
    }

    /**
     * @return array<string>
     */
    public static function message(string $text, string $color, string $bgColor): array
    {
        return [
            "<fg=$color;bg=$bgColor>" . self::line('') . '</>',
            "<fg=$color;bg=$bgColor>" . self::line($text) . '</>',
            "<fg=$color;bg=$bgColor>" . self::line('') . '</>',
            '',
        ];
    }
}
