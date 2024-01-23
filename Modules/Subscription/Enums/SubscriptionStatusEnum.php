<?php

namespace Modules\Subscription\Enums;


enum SubscriptionStatusEnum:string
{
    case PENDING = 'pending';  
    case APPROVED = 'approved';  
    case SUSPENDED = 'suspended';  
    case CANCELED = 'canceled';  
}