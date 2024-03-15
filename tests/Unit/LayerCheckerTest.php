<?php

namespace JulianaSaran\CleanArchChecker\Unit;

use JulianaSaran\CleanArchChecker\LayerChecker;
use PHPUnit\Framework\TestCase;

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
                    'use JulianaSaran\CleanArchChecker\fixtures\Order\Domain\Orders;',
                    'use JulianaSaran\CleanArchChecker\fixtures\User\Domain\Users;',
                ],
                '/Order/Domain/Order.php' => [
                    'use JulianaSaran\CleanArchChecker\fixtures\User\Domain\User;',
                ],
                '/User/Presenter/CreateUserController.php' => [
                    'use JulianaSaran\CleanArchChecker\fixtures\User\Application\CreateUserCommandHandler;',
                    'use JulianaSaran\CleanArchChecker\fixtures\User\Domain\User;',
                ],
                '/User/Application/CreateUserCommandHandler.php' => [
                    'use JulianaSaran\CleanArchChecker\fixtures\User\Domain\Users;',
                ],
                '/User/Infrastructure/DatabaseUsers.php' => [
                    'use JulianaSaran\CleanArchChecker\fixtures\User\Domain\User;',
                    'use JulianaSaran\CleanArchChecker\fixtures\User\Domain\Users;',
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

        $leaking = $checker->check($basepath, 'User', ['JulianaSaran\CleanArchChecker\fixtures\User']);

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
            'JulianaSaran\CleanArchChecker\fixtures\User\Domain',
            'JulianaSaran\CleanArchChecker\fixtures\User\Application',
        ];

        $leaking = $checker->check($basepath, 'User/Presenter', $namespaces);

        $this->assertEquals(
            expected: [],
            actual: $leaking,
        );
    }
}
