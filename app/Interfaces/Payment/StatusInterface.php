<?php

namespace App\Interfaces\Payment;

interface StatusInterface
{
    const PEDDING = 'waiting';
    const PAID = 'paid';
    const REFUSED = 'refused';
}
