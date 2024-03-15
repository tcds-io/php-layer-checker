<?php

namespace Tcds\Io\Player\Unit;

use PHPUnit\Framework\TestCase;
use Tcds\Io\Player\LayerChecker;

class LayerCheckerTest extends TestCase
{
    /**
     * @test
     */
    public function givenAnEmptyNamespaceArrayThenAllFilesShouldBeLeaking(): void
    {
        $checker = new LayerChecker();
        $basepath = realpath(__DIR__ . '/../fixtures');

        $leaking = $checker->check($basepath, '', []);

        $this->assertEquals(
            expected: [
                '/Order/Application/PlaceOrderCommandHandler.php' => [
                    'use Tcds\Io\Player\fixtures\Order\Domain\Orders;',
                    'use Tcds\Io\Player\fixtures\User\Domain\Users;',
                ],
                '/Order/Domain/Order.php' => [
                    'use Tcds\Io\Player\fixtures\User\Domain\User;',
                ],
                '/User/Presenter/CreateUserController.php' => [
                    'use Tcds\Io\Player\fixtures\User\Application\CreateUserCommandHandler;',
                    'use Tcds\Io\Player\fixtures\User\Domain\User;',
                ],
                '/User/Application/CreateUserCommandHandler.php' => [
                    'use Tcds\Io\Player\fixtures\User\Domain\Users;',
                ],
                '/User/Infrastructure/DatabaseUsers.php' => [
                    'use Tcds\Io\Player\fixtures\User\Domain\User;',
                    'use Tcds\Io\Player\fixtures\User\Domain\Users;',
                ],
            ],
            actual: $leaking,
        );
    }

    /**
     * @test
     */
    public function givenUserNamespaceWhenCheckingUserModuleThenDoNotFindAnyLeakingLayer(): void
    {
        $checker = new LayerChecker();
        $basepath = realpath(__DIR__ . '/../fixtures');

        $leaking = $checker->check($basepath, 'User', ['Tcds\Io\Player\fixtures\User']);

        $this->assertEquals(expected: [], actual: $leaking);
    }

    /**
     * @test
     */
    public function givenUserNamespaceWhenCheckingUserPresenterModuleThenDoNotFindAnyLeakingLayer(): void
    {
        $checker = new LayerChecker();
        $basepath = realpath(__DIR__ . '/../fixtures');
        $namespaces = [
            'Tcds\Io\Player\fixtures\User\Domain',
            'Tcds\Io\Player\fixtures\User\Application',
        ];

        $leaking = $checker->check($basepath, 'User/Presenter', $namespaces);

        $this->assertEquals(
            expected: [],
            actual: $leaking,
        );
    }
}
