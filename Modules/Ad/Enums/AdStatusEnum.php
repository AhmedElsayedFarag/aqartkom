<?php

namespace Modules\Ad\Enums;


enum AdStatusEnum: string
{
    case PENDING    = 'pending';
    case APPROVED   = 'approved';
    case CANCELLED   = 'cancelled';
    case CLOSED     = 'closed';
}