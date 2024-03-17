<?php

declare(strict_types=1);

namespace Tcds\Io\Player;

use Exception;
use Tcds\Io\Player\Exception\UnacceptableUsagesException;

readonly class Player
{
    public function __construct(private Layer $layer)
    {
    }

    /**
     * @param array{
     *     basepath?: string,
     *     default?: array<string>,
     *     modules?: array<array{
     *          module?: string,
     *          extends?: array<string>,
     *          accepts?: array<string>,
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

        $layers = [];

        foreach ($modules as $module) {
            $name = $module['module'] ?? throw new Exception('Configuration is missing `module` property');
            $accepts = array_merge($module['accepts'] ?? [], $default);

            $layers[$name] = $accepts;
        }

        foreach ($modules as $module) {
            $name = $module['module'] ?? throw new Exception('Configuration is missing `module` property');
            $extends = array_map(fn(string $extend) => $layers[$extend] ?? [], $module['extends'] ?? []);
            $accepts = array_merge($module['accepts'] ?? [], $default, ...$extends);

            $result = $this->layer->check($path, $name, $accepts);

            if ($result === []) {
                continue;
            }

            $leaking = array_merge($leaking, $result);
        }

        if ([] === $leaking) {
            return;
        }

        throw new UnacceptableUsagesException($leaking);
    }

    public static function create(): self
    {
        return new self(new Layer());
    }
}
