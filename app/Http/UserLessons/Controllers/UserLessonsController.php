<?php

namespace TrainingTracker\Http\UserLessons\Controllers;

use Illuminate\Validation\Rule;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\UserLessons\Classes\UpdateUserLesson;

class UserLessonsController extends Controller
{

    public function __construct()
    {
        $this->middleware(
            'role:administrator|supervisor|head_of_operations|manager',
            ['only' => ['update']]
        );
    }
    /**
     * Display the specified resource.
     *
     * @param  \TrainingTracker\UserLesson  $userLesson
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, UserLesson $userlesson)
    {
        $userlesson->load('user');
        
        return view('userlessons.show', compact('userlesson', 'user'));
    }

    public function update(User $user, UserLesson $userlesson)
    {
        request()->validate([
            'statuses.*' => [
                'nullable',
                Rule::in(['c', 'd', 'e']),
            ]
        ]);

        $userlesson->update([
            'p9' => request('statuses')['p9'],
            'p18' => request('statuses')['p18'],
            'p30' => request('statuses')['p30'],
            'p42' => request('statuses')['p42']
        ]);

        $userlesson->load('user');

        return response()->json([
            'flash' => trans('app.flash.lessonpackageupdated'),
            'userlesson' => $userlesson
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \TrainingTracker\UserLesson  $userLesson
     * @return \Illuminate\Http\Response
     */
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
}
