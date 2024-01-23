<?php

namespace Modules\Users\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Modules\Users\Filters\Search;
use Modules\Users\Http\Requests\RoleStoreRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $roles = app(Pipeline::class)
            ->send(Role::where('id', '>', 6))
            ->through([
                Search::class,
            ])
            ->thenReturn()
            ->latest()
            ->paginate(15);
        return view('users::roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $permissions = Permission::select(['id', 'name'])->get();
        return view('users::roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(RoleStoreRequest $request)
    {
        $role = Role::create(['name' => $request->get('name')]);
        $role->syncPermissions($request->get('permissions'));
        return success_add('role.index');
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::select(['id', 'name'])->get();
        return view('users::roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(RoleStoreRequest $request, Role $role)
    {
        $role->update(['name' => $request->get('name')]);
        $role->syncPermissions($request->get('permissions'));
        return success_update('role.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return success_delete('role.index');
    }
}