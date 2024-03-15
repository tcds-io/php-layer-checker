<?php

namespace JulianaSaran\CleanArchChecker\fixtures\User\Presenter;

use Exception;
use JulianaSaran\CleanArchChecker\fixtures\User\Application\CreateUserCommandHandler;
use JulianaSaran\CleanArchChecker\fixtures\User\Domain\User;

class CreateUserController
{
    private CreateUserCommandHandler $handler;

    public function __construct(CreateUserCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(): User
    {
        throw new Exception('Not Implemented');
    }
}
