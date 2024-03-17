<?php

namespace Tcds\Io\Player\Unit;

use PHPUnit\Framework\TestCase;
use Tcds\Io\Player\LayerChecker;
use Tcds\Io\Player\ModulesChecker;

class ModulesCheckerTest extends TestCase
{
    /**
     * @test
     */
    public function givenMultipleModuleConfigurationThenCheckLeakingLayers(): void
    {
        $config = [
            'basepath' => __DIR__ . '/../fixtures',
            'modules' => [
                [
                    'module' => 'Order/Application',
                    'accepts' => [
                        'Tcds\Io\Player\fixtures\Order\Application',
                        'Tcds\Io\Player\fixtures\Order\Domain',
                    ],
                ],
                [
                    'module' => 'User/Application',
                    'accepts' => [
                        'Tcds\Io\Player\fixtures\User\Application',
                        'Tcds\Io\Player\fixtures\User\Domain',
                    ],
                ],
            ],
        ];

        dd(json_encode($config));

        $layerChecker = new LayerChecker();
        $moduleChecker = new ModulesChecker($layerChecker);

        $leaking = $moduleChecker->check($config);

        $this->assertEquals(
            expected: [
                '/Order/Application/PlaceOrderCommandHandler.php' => [
                    'use Tcds\Io\Player\fixtures\User\Domain\Users;',
                ],
            ],
            actual: $leaking,
        );
    }
}
