<?php

namespace Julianasaran\CleanArchChecker\fixtures\User\Infrastructure;

use DateTime;
use Exception;
use Julianasaran\CleanArchChecker\fixtures\User\Domain\User;
use Julianasaran\CleanArchChecker\fixtures\User\Domain\Users;

class DatabaseUsers implements Users
{
    public function loadById(string $id): User
    {
        throw new Exception("NOT IMPLEMENTED");
    }
}

