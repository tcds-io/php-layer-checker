<?php

namespace Tcds\Io\Player;

use Exception;
use Tcds\Io\Player\Exception\UnacceptableUsagesException;

readonly class Player
{
    public function __construct(
        private ModulesChecker $checker,
    ) {
    }

    /**
     * @param array{
     *     basepath:string,
     *     default:array<string>,
     *     modules: array{module:string, accepts: array<string>}
     * } $config
     * @throws Exception
     */
    public function check(array $config): void
    {
        $leaking = $this->checker->check($config);

        if ([] === $leaking) {
            return;
        }

        $error = [];

        foreach ($leaking as $classes) {
            /**
             * Not good
             */
            foreach ($classes as $class => $imports) {
                /**
                 * Noooooooot good
                 */
                foreach ($imports as $import) {
                    /**
                     * @TODO: change base checker to return the proper format right away
                     */
                    $error[$class][] = $import;
                }
            }
        }

        throw new UnacceptableUsagesException($error);
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
