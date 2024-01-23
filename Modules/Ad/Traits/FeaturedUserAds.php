<?php

namespace Modules\Ad\Traits;

use Illuminate\Pipeline\Pipeline;

trait FeaturedUserAds
{
    public function getFeaturedUserAds(int $userID, bool $is_license_request = false)
    {
        return app(Pipeline::class)
            ->send(
                $this->baseUserAdQuery()
                    ->where('is_featured', 1)
                    ->owner($userID)
                    ->orderByDesc('ads.id')
            )
            ->through($this->getUserBaseFilters())
            ->thenReturn()
            ->paginate(15);
    }
}