<?php

namespace Modules\Subscription\Contracts;

interface IActiveSubscription
{
    public function check(): bool;
}