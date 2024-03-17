<?php

namespace Tcds\Io\Player;

use Exception;

readonly class ModulesChecker
{
    public function __construct(private LayerChecker $layer)
    {
    }

    /**
     * @param array{
     *     basepath:string,
     *     default:array<string>,
     *     modules: array{module:string, accepts: array<string>}
     * } $config
     * @throws Exception
     */
    public function check(array $config): array
    {
        $leaking = [];
        $path = $config['basepath'] ?? throw new Exception('Configuration is missing `basepath` property');
        $modules = $config['modules'] ?? [];
        $default = $config['default'] ?? [];

        foreach ($modules as $layer) {
            $module = $layer['module'] ?? throw new Exception('Configuration is missing `module` property');
            $accepts = array_merge($layer['accepts'] ?? [], $default);

            $result = $this->layer->check($path, $module, $accepts);

            if ($result === []) {
                continue;
            }

            $leaking[$module] = $result;
        }

        return $leaking;
    }
}
