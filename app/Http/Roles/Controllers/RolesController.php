<?php

namespace TrainingTracker\Http\Roles\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Http\Roles\Requests\StoreRoleRequest;

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
}
