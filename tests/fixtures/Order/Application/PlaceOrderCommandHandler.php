<?php

namespace JulianaSaran\CleanArchChecker\fixtures\Order\Application;

use JulianaSaran\CleanArchChecker\fixtures\Order\Domain\Orders;
use JulianaSaran\CleanArchChecker\fixtures\User\Domain\Users;

class PlaceOrderCommandHandler
{
    public function __construct(
        private Users  $users,
        private Orders $orders
    )
    {
    }
}
