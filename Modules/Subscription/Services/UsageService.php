<?php

namespace Modules\Subscription\Services;

use Illuminate\Database\Eloquent\Model;
use Modules\Package\Enums\PackageFeatureTypeEnum;
use Modules\Subscription\Contracts\IUsable;
use Modules\Subscription\Entities\Usage;

class UsageService
{

    public static function create(PackageFeatureTypeEnum $type, Model $usable, bool $fromPackage = false)
    {
        Usage::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'user_type' => auth()->user()->type,
            'user_phone' => auth()->user()->phone,
            'from_package' => $fromPackage,
            'title' => __('features.usage')[$type->value],
            // 'description' => $usable->getUsageDescription($type),
            'usable_id' => $usable->id,
            'usable_type' => get_class($usable),
        ]);
    }
}
