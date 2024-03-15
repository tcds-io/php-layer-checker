<?php

namespace Tcds\Io\Player\fixtures\User\Domain;

interface Users
{
    public function loadById(string $id): User;
}
