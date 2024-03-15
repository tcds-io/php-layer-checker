<?php

namespace Tcds\Io\Player\fixtures\Order\Domain;

interface Orders
{
    public function place(order $order): void;
}
