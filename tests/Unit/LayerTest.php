<?php

declare(strict_types=1);

namespace Tcds\Io\Player\Unit;

use PHPUnit\Framework\TestCase;
use Tcds\Io\Player\Layer;

class LayerTest extends TestCase
{
    private string $path;

    protected function setUp(): void
    {
        $this->path = realpath(__DIR__ . '/../fixtures');
    }

    public function testGivenAnEmptyNamespaceArrayThenAllFilesShouldBeLeaking(): void
    {
        $checker = new Layer();

        $leaking = $checker->check($this->path, '', []);

        $this->assertEquals(
            expected: [
                "$this->path/Order/Application/PlaceOrderCommandHandler.php" => [
                    '- Tcds\Io\Player\fixtures\Order\Domain\Orders',
                    '- Tcds\Io\Player\fixtures\User\Domain\Users',
                ],
                "$this->path/Order/Domain/Order.php" => [
                    '- Tcds\Io\Player\fixtures\User\Domain\User',
                ],
                "$this->path/User/Application/CreateUserCommandHandler.php" => [
                    '- Tcds\Io\Player\fixtures\User\Domain\Users',
                ],
                "$this->path/User/Infrastructure/DatabaseUsers.php" => [
                    '- Tcds\Io\Player\fixtures\User\Domain\User',
                    '- Tcds\Io\Player\fixtures\User\Domain\Users',
                ],
                "$this->path/User/Presenter/CreateUserController.php" => [
                    '- Tcds\Io\Player\fixtures\User\Application\CreateUserCommandHandler',
                    '- Tcds\Io\Player\fixtures\User\Domain\User',
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
        $checker = new Layer();

        $leaking = $checker->check($this->path, 'User', ['Tcds\Io\Player\fixtures\User']);

        $this->assertEquals(expected: [], actual: $leaking);
    }

    /**
     * @test
     */
    public function givenUserNamespaceWhenCheckingUserPresenterModuleThenDoNotFindAnyLeakingLayer(): void
    {
        $checker = new Layer();
        $namespaces = [
            'Tcds\Io\Player\fixtures\User\Domain',
            'Tcds\Io\Player\fixtures\User\Application',
        ];

        $leaking = $checker->check($this->path, 'User/Presenter', $namespaces);

        $this->assertEquals(
            expected: [],
            actual: $leaking,
        );
    }
}
