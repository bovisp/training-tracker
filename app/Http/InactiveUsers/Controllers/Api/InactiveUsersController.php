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
                    ['field' => 'firstname', 'label' => trans('app.datatable.label.firstname'), 'sortable' => 'sortable'],
                    ['field' => 'lastname', 'label' => trans('app.datatable.label.lastname'), 'sortable' => 'sortable'],
                    ['field' => 'email', 'label' => trans('app.datatable.label.email'), 'sortable' => 'sortable']
                ],
                'orderby' => [
                    ['key' => 'lastname', 'dir' => 'desc'],
                    ['key' => 'firstname', 'dir' => 'desc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => env('APP_URL') . '/users/',
                    'endpointSuffix' => '',
                    'text' => trans('app.datatable.buttons.profile')
                ]
            ]
        ];
    }
}
