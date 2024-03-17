<?php

declare(strict_types=1);

namespace Tcds\Io\Player\fixtures\User\Domain;

interface Users
{
    public function loadById(string $id): User;
}
