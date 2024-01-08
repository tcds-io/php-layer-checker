<?php

namespace Julianasaran\CleanArchChecker\fixtures\Order\Domain;

interface Orders
{
    public function place(order $order): void;
}
