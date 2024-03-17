<?php

declare(strict_types=1);

namespace Tcds\Io\Player\fixtures\Order\Domain;

interface Orders
{
    public function place(order $order): void;
}
