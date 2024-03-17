<?php

namespace Tcds\Io\Player;

use Exception;

readonly class ModulesChecker
{
    public function __construct(private LayerChecker $layer)
    {
    }

    /**
     * @param array{basepath:string, modules: array{module:string, accepts: array<string>}} $config
     * @throws Exception
     */
    public function check(array $config): array
    {
        $leaking = [];
        $path = $config['basepath'] ?? throw new Exception('Configuration is missing `basepath` property');
        $modules = $config['modules'] ?? [];

        foreach ($modules as $module) {
            $module = $module['module'] ?? throw new Exception('Configuration is missing `module` property');
            $accepts = $module['accepts'] ?? [];

            $result = $this->layer->check($path, $module, $accepts);

            if ($result === []) {
                continue;
            }

            $leaking[$module] = $result;
        }

        return $leaking;
    }
}
