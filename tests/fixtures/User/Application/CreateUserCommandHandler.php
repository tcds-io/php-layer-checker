<?php

declare(strict_types=1);

namespace Tcds\Io\Player\fixtures\User\Application;

use Tcds\Io\Player\fixtures\User\Domain\Users;

class CreateUserCommandHandler
{
    public function __construct(private Users $users,)
    {
    }
}
