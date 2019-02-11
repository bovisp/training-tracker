<?php

namespace TrainingTracker\Http\UserLessons\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\App\Rules\UserLessonCompleted;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\UserLessons\Classes\UpdateUserLesson;
use TrainingTracker\Http\UserLessons\Requests\UserlessonRequest;

class UserLessonsController extends Controller
{

    public function __construct()
    {
        $this->middleware(
            'role:administrator|supervisor|head_of_operations|manager',
            ['only' => ['update']]
        );
    }
    
    public function show(User $user, UserLesson $userlesson)
    {
        $userlesson->load(['user', 'lesson.objectives', 'user.objectives']);
        
        return view('userlessons.show', compact('userlesson', 'user'));
    }

    public function update(UserlessonRequest $request, User $user, UserLesson $userlesson)
    {
        if (moodleauth()->user()->hasRole(['administrator', 'supervisor', 'head_of_operations'])) {
            $this->updateObjectivesandStatus($user, $userlesson);
        }        

        if (moodleauth()->user()->hasRole(['administrator', 'manager', 'head_of_operations'])) {
            $this->updateCompleted($userlesson);
        }

        $userlesson->load(['user', 'lesson.objectives', 'user.objectives']);

        return response()->json([
            'flash' => trans('app.flash.lessonpackageupdated'),
            'userlesson' => $userlesson
        ]);
    }

    public function destroy(User $user, UserLesson $userlesson)
    {
        $userlesson->delete();

        return redirect()
            ->route('users.show', ['user' => $user->id])
            ->with([
                'flash' => [
                    'message' => trans('app.flash.lessonpackagedeleted')
                ]
            ]);
    }

    protected function validateCompletedStatus(UserLesson $userlesson)
    {
        Validator::make(request()->all(), [
            'completed' => [
                new UserLessonCompleted($userlesson->load([
                    'lesson.objectives', 'lesson', 'user', 'user.objectives'
                ]))
            ]
        ])->validate();

        return true;
    }

    protected function updateCompleted(UserLesson $userlesson)
    {
        if ((int) request('completed') === 1) {
            $this->validateCompletedStatus($userlesson);
        }

        $userlesson->update([
            'completed' => (int) request('completed')
        ]);
    }

    protected function updateObjectivesandStatus(User $user, UserLesson $userlesson)
    {
        $userlesson->update([
            'p9' => request('statuses')['p9'],
            'p18' => request('statuses')['p18'],
            'p30' => request('statuses')['p30'],
            'p42' => request('statuses')['p42']
        ]);

        $user->updateObjectives($userlesson);
    }
}
