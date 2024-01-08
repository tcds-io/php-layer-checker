<?php

namespace Julianasaran\CleanArchChecker\Unit;

use Julianasaran\CleanArchChecker\LayerChecker;
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
            expected: [],
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

        $leaking = $checker->check($basepath, 'User', ['Julianasaran\CleanArchChecker\fixtures\User']);

        $this->assertEquals(
            expected: [
                '/User/Infrastructure/DatabaseUsers.php' => [
                    'use Exception;',
                ],
            ],
            actual: $leaking,
        );
    }
}
