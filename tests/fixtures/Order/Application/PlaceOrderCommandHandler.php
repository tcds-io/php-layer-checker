<?php

namespace Julianasaran\CleanArchChecker\fixtures\Order\Application;

use Julianasaran\CleanArchChecker\fixtures\Order\Domain\Orders;
use Julianasaran\CleanArchChecker\fixtures\User\Domain\Users;

class PlaceOrderCommandHandler
{
    public function __construct(
        private Users  $users,
        private Orders $orders
    )
    {
    }
}
