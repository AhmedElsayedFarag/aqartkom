<?php

namespace Modules\Auth\Services;

use Modules\Auth\Entities\MarketerProfile;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Requests\Api\MarketersFilterRequest;
use Modules\Auth\Http\Requests\Api\RegisterRequest;

class MarketerProfileService
{
    public static function create(RegisterRequest $request, User $user)
    {
        $user->marketerProfile()->create($request->all());
    }
    public static function getAll(MarketersFilterRequest $request)
    {
        return User::with('marketerProfile')
            ->withCount(['ads' => fn ($query) => $query->where('status', 'approved')])
            ->where('type', 'marketer')
            ->join('marketer_profiles', 'marketer_profiles.user_id', '=', 'users.id')
            ->when($request->get('search'), fn ($q) => $q->where('name', 'like', "%{$request->get('search')}%"))
            ->when($request->get('city'), fn ($q) => $q->where('city_id', $request->get('city')))
            ->paginate(16);
    }
}