<?php


namespace Modules\Users\Services;

use Illuminate\Pipeline\Pipeline;
use Modules\Auth\Entities\User;
use Modules\Users\Filters\AccountSearch;
use Modules\Users\Filters\BlockSearch;
use Modules\Users\Filters\EmailSearch;
use Modules\Users\Filters\IDSearch;
use Modules\Users\Filters\PhoneSearch;
use Modules\Users\Filters\Search;
use Spatie\Permission\Models\Role;

class UsersService
{
    public function getRoleID(string $roleName): int
    {
        return Role::select(['id'])->firstWhere('name', $roleName)->id;
    }
    public function get(string $roleName)
    {
        return app(Pipeline::class)
            ->send($this->prepareQuery($roleName))
            ->through([
                Search::class,
                AccountSearch::class,
                BlockSearch::class
            ])
            ->thenReturn()
            ->latest();
    }
    public function getAdmins()
    {
        return $this->get('admin')->paginate(15);
    }
    public function getOwners()
    {
        return $this->get('owner')->paginate(15)->appends(request()->all());
    }
    public function getCustomers()
    {
        return $this->get('customer')->paginate(15)->appends(request()->all());
    }
    public function getCompanies()
    {
        return $this->get('company')->with('companyProfile')->paginate(15)->appends(request()->all());
    }
    public function getMarketers()
    {
        return $this->get('marketer')->paginate(15)->appends(request()->all());
    }

    private function prepareQuery(string $roleName)
    {
        $query = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->where('role_id', $this->getRoleID($roleName));
        if ($roleName == 'admin')
            return $this->prepareAdminQuery($query);
        if ($roleName == 'company')
            return $this->prepareCompanyQuery($query);
        if ($roleName == 'marketer')
            return $this->prepareMarketerQuery($query);
        // if ($roleName == 'owner')
        //     return $query;
        // if ($roleName == 'customer')
        //     return $query;
        return $query;
    }
    private function prepareAdminQuery($query)
    {
        return $query->where('users.id', '>', 1);
    }
    private function prepareCompanyQuery($query)
    {
        return $query->with([
            'companyProfile' => fn ($query) => $query->select(['user_id', 'id', 'logo', 'city_id', 'whatsapp_number', 'commercial_register_number']),
            'companyProfile.city' => fn ($query) => $query->select(['id', 'name'])
        ]);
    }
    private function prepareMarketerQuery($query)
    {
        return $query->with([
            'marketerProfile' => fn ($query) => $query->select(['user_id', 'whatsapp_number', 'advertisement_number']),
        ]);
    }
}