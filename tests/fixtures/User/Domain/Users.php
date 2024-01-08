<?php

namespace Julianasaran\CleanArchChecker\fixtures\User\Domain;

interface Users
{
    public function loadById(string $id): User;
}
