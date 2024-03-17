<?php

declare(strict_types=1);

namespace Tcds\Io\Player\fixtures\Order\Domain;

use DateTime;
use Tcds\Io\Player\fixtures\User\Domain\User;

class Order
{
    public string $id;
    public User $customer;
    public DateTime $placedAt;

    public function __construct(string $id, User $customer, DateTime $placedAt,)
    {
        $this->id = $id;
        $this->customer = $customer;
        $this->placedAt = $placedAt;
    }
}
