<?php

namespace Julianasaran\CleanArchChecker\fixtures\User\Application;

use Julianasaran\CleanArchChecker\fixtures\User\Domain\Users;

class CreateUserCommandHandler
{
    public function __construct(
        private Users $users,
    )
    {
    }
}
