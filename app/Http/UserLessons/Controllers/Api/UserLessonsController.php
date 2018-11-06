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
                    ['field' => 'level', 'label' => 'Level', 'sortable' => 'sortable'],
                    ['field' => 'package', 'label' => 'Lesson package', 'sortable' => 'sortable'],
                    ['field' => 'completed', 'label' => 'Completed', 'sortable' => 'sortable'],
                ],
                'orderby' => [
                    ['key' => 'level', 'dir' => 'asc'],
                    ['key' => 'package', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => env('APP_URL') . "/users/{$user->id}/userlessons/",
                    'endpointSuffix' => '',
                    'text' => 'View'
                ]
            ]
        ];
    }

    public function show(User $user, UserLesson $userlesson)
    {
        $userlesson->load(['lesson.level']);

        $user->load(['moodleuser']);

        return [
            'userlesson' => [
                'id' => $userlesson->id,
                'lesson' => $userlesson->lesson,
                'level' => $userlesson->lesson->level,
                'status' => [
                    'p9' => $userlesson->p9,
                    'p18' => $userlesson->p18,
                    'p30' => $userlesson->p30,
                    'p42' => $userlesson->p42
                ],
                'objectives' => $userlesson->lesson->objectives,
                'logbooks' => $user->logbooks->whereIn('userlesson_id', [$userlesson->id]),
                'completedObjectives' => $user->completedObjectives(),
            ],
            'user' => [
                'id' => $user->id,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
            ],
            'auth' => [
                'role' => moodleauth()->user()->roles->first()->type
            ],
            'completedPackage' => $userlesson->completed
        ];
    }
}
