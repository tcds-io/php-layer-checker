<?php

declare(strict_types=1);

namespace Tcds\Io\Player\fixtures\Order\Application;

use Tcds\Io\Player\fixtures\Order\Domain\Orders;
use Tcds\Io\Player\fixtures\User\Domain\Users;

class PlaceOrderCommandHandler
{
    public function __construct(private Users $users, private Orders $orders,)
    {
    }
}
