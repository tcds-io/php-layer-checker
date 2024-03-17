<?php

namespace Tcds\Io\Player;

use Exception;

readonly class Player
{
    public function __construct(
        private ModulesChecker $checker,
    ) {
    }

    /**
     * @param array{basepath:string, modules: array{modules:string, accepts: array<string>}} $config
     * @throws Exception
     */
    public function check(array $config): void
    {
        $this->checker->check($config);
    }

    public static function create(): Player
    {
        return new Player(
            checker: new ModulesChecker(
                layer: new LayerChecker(),
            ),
        );
    }
}
