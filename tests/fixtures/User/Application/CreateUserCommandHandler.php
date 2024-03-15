<?php

namespace JulianaSaran\CleanArchChecker\fixtures\User\Application;

use JulianaSaran\CleanArchChecker\fixtures\User\Domain\Users;

class CreateUserCommandHandler
{
    public function __construct(
        private Users $users,
    )
    {
    }
}
