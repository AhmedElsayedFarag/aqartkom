<?php

namespace Modules\Ad\Enums;


enum AdAdvertiser: string
{
    case OWNER    = 'owner';
    case AGENT   = 'agent';
    case MARKETER   = 'marketer';
}