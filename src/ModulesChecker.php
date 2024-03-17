<?php

namespace Tcds\Io\Player;

use Exception;

class ModulesChecker
{
    public function __construct(private LayerChecker $layer)
    {
    }

    public function check(array $config): array
    {
        $leaking = [];
        $modules = $config['modules'] ?? [];

        foreach ($modules as $module) {
            $path = $config['basepath'] ?? throw new Exception('Configuration is missing `basepath` property');
            $module = $module['module'] ?? throw new Exception('Configuration is missing `module` property');
            $accepts = $module['accepts'] ?? [];

            $result = $this->layer->check($path, $module, $accepts);

            if ($result !== []) {
                $leaking = array_merge($leaking, $result);
            }
        }

        return $leaking;
    }
}
