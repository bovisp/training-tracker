<?php

namespace TrainingTracker\Http\UserLessons\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\UserLessons\Classes\UpdateUserLesson;

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
        return view('userlessons.show', compact('userlesson', 'user'));
    }

    public function update(User $user, UserLesson $userlesson)
    {
        $res = (new UpdateUserLesson($user, $userlesson))
            ->update();

        if (count($res) && !array_key_exists('errors', $res)) {
            return response()->json(['errors' => $res], 422);
        } else if (count($res) && array_key_exists('errors', $res)) {
            return response()->json(['errors' => $res], 403);
        } else {
            return response()->json([
                'flash' => trans('app.flash.lessonpackageupdated')
            ]);
        }
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
