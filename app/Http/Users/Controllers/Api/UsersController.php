<?php

namespace TrainingTracker\Http\Users\Controllers\Api;

use TrainingTracker\App\Controllers\DatatablesController;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\Users\Requests\StoreUsersSpreadsheet;
use TrainingTracker\Http\Users\Requests\UpdateAppointmentUserRequest;

class UsersController extends DatatablesController
{

	public function builder()
    {
        return User::query();
    }

    public function getDisplayableColumns()
    {
        return ['id'];
    }

    public function index()
    {
        return response()->json([
            'data' => [
                'records' => User::active(),
                'displayable' => $this->getDisplayableColumns(),
            ]
        ]); 
    }

    public function create()
    {
        return response()->json([
            'data' => [
                'records' => User::notIn(),
                'displayable' => $this->getDisplayableColumns(),
                'roles' => Role::all()
            ]
        ]);
    }

    public function store()
    {
        $validations = new StoreUsersSpreadsheet(request()->all());

        if (count($validations->validate())) {
            return response()->json([
                'errors' => $validations->validate()
            ], 422);
        } else {
            return response()->json([
                'flash' => 'users added successfully!'
            ]);
        }
    }
}
