<?php

namespace TrainingTracker\Http\InactiveUsers\Controllers\Api;

use TrainingTracker\App\Controllers\DatatablesController;
use TrainingTracker\Domains\Users\User;

class InactiveUsersController extends DatatablesController
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
                'records' => $this->getRecords(),
                'displayable' => $this->getDisplayableColumns(),
            ]
        ]); 
    }

    protected function getRecords()
    {
        $users = [];

        foreach(User::inactive() as $user) {
            $users[] = [
                'id' => $user->id,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email
            ];
        }

        return $users;
    }
}
