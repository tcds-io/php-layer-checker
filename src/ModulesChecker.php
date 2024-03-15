<?php

namespace Tcds\Io\Player;

class ModulesChecker
{
    public function __construct(private LayerChecker $layer)
    {
    }

    public function check(array $config): array
    {
        $leaking = [];

        foreach ($config['modules'] as $module) {
            $result = $this->layer->check($config['basepath'], $module['module'], $module['accepts']);

            if ($result !== []) {
                $leaking = array_merge($leaking, $result);
            }
        }

        return $leaking;
    }
}
