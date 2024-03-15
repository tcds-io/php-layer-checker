<?php

namespace JulianaSaran\CleanArchChecker\Unit;

use JulianaSaran\CleanArchChecker\LayerChecker;
use JulianaSaran\CleanArchChecker\ModulesChecker;
use PHPUnit\Framework\TestCase;

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
                        'JulianaSaran\CleanArchChecker\fixtures\Order\Application',
                        'JulianaSaran\CleanArchChecker\fixtures\Order\Domain',
                    ],
                ],
                [
                    'module' => 'User/Application',
                    'accepts' => [
                        'JulianaSaran\CleanArchChecker\fixtures\User\Application',
                        'JulianaSaran\CleanArchChecker\fixtures\User\Domain',
                    ],
                ],
            ],
        ];

        $layerChecker = new LayerChecker();
        $moduleChecker = new ModulesChecker($layerChecker);

        $leaking = $moduleChecker->check($config);

        $this->assertEquals(
            expected: [
                '/Order/Application/PlaceOrderCommandHandler.php' => [
                    'use JulianaSaran\CleanArchChecker\fixtures\User\Domain\Users;'
                ],
            ],
            actual: $leaking,
        );
    }
}
