<?php

namespace Modules\Favorite\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\CompanyProfile;
use Modules\Favorite\Contracts\FavoriteInterface;
use Modules\Users\Transformers\CompaniesResource;

class FavoriteCompanyService implements FavoriteInterface
{
    public function  toggle(int $modelID)
    {
        return auth()->user()->favoriteCompanies()->toggle($modelID);
    }
    public function getAll(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return DB::table('favorites')
            ->select(['company_profiles.uuid', 'company_profiles.logo', 'users.name'])
            ->join('company_profiles', 'company_profiles.id', '=', 'favorites.favoritable_id')
            ->join('users', 'users.id', '=', 'company_profiles.user_id')
            ->where('favorites.user_id', auth()->id())
            ->where('favoritable_type', CompanyProfile::class)
            ->paginate();
    }
    public function validate(string $modelUUID): int|ModelNotFoundException
    {
        return CompanyProfile::select(['id'])->where('uuid', $modelUUID)->firstOrFail()?->id;
    }
    public function toJson(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CompaniesResource::collection($this->getAll());
    }
    public function isExist(int $id): bool
    {
        return auth()->user()->favoriteCompanies()->where('favoritable_id', $id)->exists();
    }
}