<?php

declare(strict_types=1);

namespace Tcds\Io\Player\Unit;

use PHPUnit\Framework\TestCase;
use Tcds\Io\Player\Exception\UnacceptableUsagesException;
use Tcds\Io\Player\ExpectThrows;
use Tcds\Io\Player\Layer;
use Tcds\Io\Player\Player;

class PlayerTest extends TestCase
{
    use ExpectThrows;

    private string $path;

    protected function setUp(): void
    {
        $this->path = realpath(__DIR__ . '/../fixtures');
    }

    public function testGivenMultipleModuleConfigurationThenCheckLeakingLayers(): void
    {
        $config = [
            'basepath' => $this->path,
            'modules' => [
                [
                    'accepts' => [
                        'Tcds\Io\Player\fixtures\Order\Application',
                        'Tcds\Io\Player\fixtures\Order\Domain',
                    ],
                    'module' => 'Order/Application',
                ],
                [
                    'accepts' => [
                        'Tcds\Io\Player\fixtures\Order\Application',
                        'Tcds\Io\Player\fixtures\Order\Domain',
                    ],
                    'module' => 'Order/Domain',
                ],
                [
                    'accepts' => [
                        'Tcds\Io\Player\fixtures\User\Application',
                        'Tcds\Io\Player\fixtures\User\Domain',
                    ],
                    'module' => 'User/Application',
                ],
                [
                    'accepts' => [
                        'Tcds\Io\Player\fixtures\User\Application',
                        'Tcds\Io\Player\fixtures\User\Domain',
                    ],
                    'module' => 'User/Application',
                ],
            ],
        ];

        $moduleChecker = new Player(new Layer());

        $exception = $this->expectThrows(fn() => $moduleChecker->check($config));

        assert($exception instanceof UnacceptableUsagesException);
        $this->assertEquals(
            expected: [
                "$this->path/Order/Application/PlaceOrderCommandHandler.php" => [
                    '- Tcds\Io\Player\fixtures\User\Domain\Users',
                ],
                "$this->path/Order/Domain/Order.php" => [
                    '- Tcds\Io\Player\fixtures\User\Domain\User',
                ],

            ],
            actual: $exception->leaking,
        );
    }

    public function testExtendDifferentModuleConfiguration(): void
    {
        $config = [
            'basepath' => $this->path,
            'modules' => [
                [
                    'accepts' => [
                        'Tcds\Io\Player\fixtures\Order\Domain',
                    ],
                    'module' => 'Order/Domain',
                ],
                [
                    'accepts' => [
                        'Tcds\Io\Player\fixtures\Order\Application',
                    ],
                    'extends' => [
                        'Order/Domain',
                    ],
                    'module' => 'Order/Application',
                ],
            ],
        ];

        $moduleChecker = new Player(new Layer());

        $exception = $this->expectThrows(fn() => $moduleChecker->check($config));

        assert($exception instanceof UnacceptableUsagesException);
        $this->assertEquals(
            [
                "$this->path/Order/Application/PlaceOrderCommandHandler.php" => [
                    '- Tcds\Io\Player\fixtures\User\Domain\Users',
                ],
                "$this->path/Order/Domain/Order.php" => [
                    '- Tcds\Io\Player\fixtures\User\Domain\User',
                ],
            ],
            $exception->leaking,
        );
    }
}
