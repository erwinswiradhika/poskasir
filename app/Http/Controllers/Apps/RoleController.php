<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::when(\request()->q, function($query) {
            $query->where('name', 'like', '%'. request()->q . '%');
        })->with("permissions")->latest()->paginate(5);

        return Inertia::render("Apps/Roles/Index", [
            "roles" => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return Inertia::render("Apps/Roles/Create", [
            "permissions" => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "permissions" => "required"
        ]);

        $role = Role::create(["name" => $request->name]);
        $role->givePermissionTo($request->permissions);

        return \redirect()->route("apps.roles.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::with("permissions")->findOrFail($id);
        $permissions = Permission::all();
        return Inertia::render("Apps/Roles/Edit", [
            "role" => $role,
            "permissions" => $permissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::with("permissions")->findOrFail($id);
        $permissions = Permission::all();

        return Inertia::render("Apps/Roles/Edit", [
            "role" => $role,
            "permissions" => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            "name" => "required",
            "permissions" => "required"
        ]);

        $role->update(["name" => $request->name]);
        $role->syncPermissions($request->permissions);

        return \redirect()->route("apps.roles.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return \redirect()->route("apps.roles.index");
    }
}