<?php

namespace TrainingTracker\Http\UserLessons\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\UserLessons\Resources\UserLessonResource;

class UserLessonsController extends Controller
{
    public function index(User $user)
    {
        return [
            'records' => UserLessonResource::collection(
                UserLesson::whereUserId($user->id)->with('lesson.level')->get()
            ),
            'meta' => [
                'displayable' => [
                    ['field' => 'level', 'label' => trans('app.datatable.label.level'), 'sortable' => 'sortable'],
                    ['field' => 'package', 'label' => trans('app.datatable.label.lessonpackage'), 'sortable' => 'sortable'],
                    ['field' => 'status', 'label' => 'Status', 'sortable' => 'sortable'],
                ],
                'orderby' => [
                    ['key' => 'level', 'dir' => 'asc'],
                    ['key' => 'package', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => env('APP_URL') . "/users/{$user->id}/userlessons/",
                    'endpointSuffix' => '',
                    'text' => trans('app.datatable.buttons.view')
                ]
            ]
        ];
    }

    public function show(UserLesson $userlesson)
    {
        $userlesson->load([
            'user', 'lesson.objectives', 'user.objectives', 'logbooks', 'logbooks.objective'
        ]);

        return $userlesson;
    }
}
