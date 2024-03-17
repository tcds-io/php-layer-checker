<?php

declare(strict_types=1);

namespace Tcds\Io\Player\fixtures\User\Presenter;

use Exception;
use Tcds\Io\Player\fixtures\User\Application\CreateUserCommandHandler;
use Tcds\Io\Player\fixtures\User\Domain\User;

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
