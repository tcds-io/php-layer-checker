<?php

declare(strict_types=1);

namespace Tcds\Io\Player\fixtures\User\Infrastructure;

use Exception;
use Tcds\Io\Player\fixtures\User\Domain\User;
use Tcds\Io\Player\fixtures\User\Domain\Users;

class DatabaseUsers implements Users
{
    public function loadById(string $id): User
    {
        throw new Exception("NOT IMPLEMENTED");
    }
}
