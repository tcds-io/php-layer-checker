<?php

declare(strict_types=1);

namespace Tcds\Io\Player;

use Exception;
use Tcds\Io\Player\Exception\UnacceptableUsages;
use Tcds\Io\Player\Exception\UndefinedConfiguration;

readonly class Player
{
    public function __construct(private Layer $layer)
    {
    }

    /**
     * @param array{
     *     basepath?: string,
     *     default?: array<string>,
     *     presets?: array<string, array<string>>,
     *     modules?: array<array{
     *          module?: string,
     *          extends?: array<string>,
     *          accepts?: array<string>,
     *          needs?: array<string>,
     *     }>,
     * } $config
     * @throws Exception
     */
    public function check(array $config): void
    {
        $leaking = [];
        $path = $config['basepath'] ?? throw new Exception('Configuration is missing `basepath` property');
        $modules = $config['modules'] ?? [];
        $default = $config['default'] ?? [];
        $presets = $config['presets'] ?? [];

        $layers = [];

        /**
         * Define basic accepted imports
         */
        foreach ($modules as $module) {
            $name = $module['module'] ?? throw new Exception('Configuration is missing `module` property');
            $accepts = array_merge($module['accepts'] ?? [], $default);

            $layers[$name] = array_merge($accepts, $default);
        }

        /**
         * Extends modules acceptable imports by its extensions
         */
        foreach ($modules as $module) {
            $name = $module['module'] ?? throw new Exception('Configuration is missing `module` property');
            $extends = array_map(
                fn(string $extend) => $layers[$extend]
                    ?? $presets[$extend]
                    ?? throw new UndefinedConfiguration($name, $extend),
                $module['extends'] ?? [],
            );

            $layers[$name] = array_values(
                array_unique(
                    array_merge($layers[$name], ...$extends),
                ),
            );
        }

        foreach ($modules as $module) {
            $name = $module['module'] ?? throw new Exception('Configuration is missing `module` property');
            $needs = $module['needs'] ?? [];
            $accepts = array_merge($layers[$name] ?? [], $needs);

            $result = $this->layer->check($path, $name, $accepts);

            if ($result === []) {
                continue;
            }

            $leaking = array_merge($leaking, $result);
        }

        if ([] === $leaking) {
            return;
        }

        throw new UnacceptableUsages($leaking);
    }

    public static function create(): self
    {
        return new self(new Layer());
    }
}
