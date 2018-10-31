<?php

namespace TrainingTracker\Http\InactiveUsers\Controllers\Api;

use Illuminate\Routing\Controller;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\InactiveUsers\Resources\InactiveUserResource;

class InactiveUsersController extends Controller
{
    public function index()
    {
        return [
            'records' => InactiveUserResource::collection(User::whereActive(0)->get()),
            'meta' => [
                'displayable' => [
                    ['key' => 'firstname', 'title' => 'First name'],
                    ['key' => 'lastname', 'title' => 'Last name'],
                    ['key' => 'email', 'title' => 'E-mail']
                ],
                'orderby' => [
                    ['key' => 'lastname', 'dir' => 'desc'],
                    ['key' => 'firstname', 'dir' => 'desc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => env('APP_URL') . '/users/',
                    'endpointSuffix' => '',
                    'text' => 'Profile'
                ]
            ]
        ];
    }
}
