<?php

namespace JulianaSaran\CleanArchChecker\fixtures\Order\Domain;

interface Orders
{
    public function place(order $order): void;
}
