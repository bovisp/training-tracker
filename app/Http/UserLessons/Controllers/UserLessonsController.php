<?php

namespace TrainingTracker\Http\UserLessons\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;

class UserLessonsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \TrainingTracker\UserLesson  $userLesson
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, UserLesson $userlesson)
    {
        $userlesson = $userlesson->whereId($userlesson->id)
            ->with('lesson.topic')
            ->first();

        $user = $user->whereId($user->id)
            ->with('moodleuser')
            ->first();

        return view('userlessons.show', compact('userlesson', 'user'));
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
                    'message' => 'Lesson package successfully deleted.'
                ]
            ]);
    }
}
