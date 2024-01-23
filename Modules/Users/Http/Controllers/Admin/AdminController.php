<?php

namespace Modules\Users\Http\Controllers\Admin;

use App\Services\BreadCrumbGenerator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\User;
use Modules\Users\Filters\Search;
use Modules\Users\Filters\EmailSearch;
use Modules\Users\Filters\PhoneSearch;
use Modules\Users\Http\Requests\AdminFilterRequest;
use Modules\Users\Http\Requests\StoreAdminRequest;
use Modules\Users\Http\Requests\UpdateAdminRequest;
use Modules\Users\Services\UsersService;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(AdminFilterRequest $request)
    {
        $usersService = new UsersService();
        $admins = $usersService->getAdmins();
        return view('users::admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = Role::select(['id', 'name'])->where('id', '>', 5)->get();
        return view('users::admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreAdminRequest $request)
    {
        $user = User::create($request->merge([
            'type' => 'admin',
            'password' => Hash::make('password')
        ])->all());

        $user->assignRole(['admin', ...$request->get('roles')]);

        return \success_add('admin.index');
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(User $user)
    {
        $roles = Role::select(['id', 'name'])->where('id', '>', 5)->get();
        $user->load('roles');
        return view('users::admins.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateAdminRequest $request, User $user)
    {
        $user->update($request->merge([
            'type' => 'admin',
            // 'password' => Hash::make($request->password)
        ])->all());

        if ($user) {

            return \success_update('admin.index');
        }
        abort(500);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(User $user)
    {
        $user->delete();
        return \success_delete('admin.index');
    }
}