<?php

namespace App\Enums;

enum OrderStatus: string
{
    // for a real-life projects we would include more states
    case PENDING = 'pending';
    case COMPLETED = 'completed';
}
