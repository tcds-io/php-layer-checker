<?php

declare(strict_types=1);

namespace Tcds\Io\Player;

class Formatter
{
    public static function line(string $text, string $fill = ' '): string
    {
        return str_pad($text, 120, $fill, STR_PAD_RIGHT);
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
