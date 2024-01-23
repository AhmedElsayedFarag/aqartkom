<?php

namespace Modules\Users\Services;

use Illuminate\Pipeline\Pipeline;
use Modules\Auth\Entities\CompanyProfile;
use Modules\Estate\Filters\City;
use Modules\Users\Filters\CompanySearch;
use Modules\Users\Filters\Search;

class CompaniesService
{

    public function getAll()
    {
        return app(Pipeline::class)
            ->send(
                CompanyProfile::select(['company_profiles.uuid', 'user_id', 'logo', 'commercial_register_number'])
                    ->join('users', 'users.id', '=', 'company_profiles.user_id')
                    ->with([
                        'user' => fn ($query) => $query->select(['id', 'users.name', 'is_authorized', 'is_featured']),
                    ])
                    ->withCount(['ads' => fn ($query) => $query->where('status', 'approved')])
            )

            ->through([
                City::class,
                CompanySearch::class,
            ])
            ->thenReturn()
            ->paginate(15);
    }
}