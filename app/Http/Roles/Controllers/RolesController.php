<?php

namespace TrainingTracker\Http\Roles\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Http\Roles\Requests\StoreRoleRequest;
use TrainingTracker\Http\Roles\Requests\UpdateRoleRequest;

class RolesController extends Controller
{
    public function index()
    {
        return view('roles.index');
    }

    public function create()
    {
    	return view('roles.create');
    }

    public function store(StoreRoleRequest $request)
    {
        Role::create([
            'type' => snake_case(request('type')),
            'rank' => request('rank'),
            'name' => [
                'en' => request('name_en'),
                'fr' => request('name_fr')
            ]
        ]);

        return redirect()
            ->route('roles.index')
            ->with([
                'flash' => [
                    'message' => "Role created successfully."
                ]
            ]);
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Role $role, UpdateRoleRequest $request)
    {
        $role->update([
            'type' => snake_case(request('type')),
            'rank' => request('rank'),
            'name' => [
                'en' => request('name_en'),
                'fr' => request('name_fr')
            ]
        ]);

        return redirect()
            ->route('roles.index')
            ->with([
                'flash' => [
                    'message' => "Role updated successfully."
                ]
            ]);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with([
                'flash' => [
                    'message' => "Role delete successfully."
                ]
            ]);
    }
}
