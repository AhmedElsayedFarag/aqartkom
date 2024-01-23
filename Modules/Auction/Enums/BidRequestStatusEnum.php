<?php

namespace Modules\Auction\Enums;


enum BidRequestStatusEnum: string
{
  case PENDING = 'pending';
  case APPROVED = 'approved';
  case DECLINED = 'declined';
  case CLOSED = 'closed';
}
