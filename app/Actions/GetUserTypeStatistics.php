<?php

namespace App\Actions;

use App\DataTransferObjects\UserCountStatisticsDto;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;

class GetUserTypeStatistics
{
    /**
     * Handle the action.
     * Get Users count by type
     *
     * @return UserCountStatisticsDto
     */
    public function handle(): UserCountStatisticsDto
    {
        $userTypeCount = User::select(['type as user_type', DB::raw('Count(id) as users_count')])
            ->groupBy('type')
            ->get()
            ->keyBy('user_type')
            ->toArray();

        return new UserCountStatisticsDto(
            $userTypeCount['customer']['users_count'] ?? 0,
            $userTypeCount['owner']['users_count'] ?? 0,
            $userTypeCount['marketer']['users_count'] ?? 0,
            $userTypeCount['company']['users_count'] ?? 0,
        );
    }
}