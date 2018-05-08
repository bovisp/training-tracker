<?php

namespace TrainingTracker\Http\UserLessons\Controllers\Api;

use TrainingTracker\App\Controllers\DatatablesController;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;


class UserLessonsController extends DatatablesController
{

	public function builder()
    {
        return UserLesson::query();
    }

    public function getDisplayableColumns()
    {
        return ['id'];
    }

    

    public function getUserLessons(User $user)
    {
        return response()->json([
            'data' => [
                'records' => $this->getLessonRecords($user),
                'displayable' => $this->getDisplayableColumns(),
            ]
        ]); 
    }

    protected function getLessonRecords(User $user)
    {
        $collection = [];

        $userlessons = UserLesson::where('user_id', $user->id)->with('lesson.topic')->get()->sort(function($a, $b) {
            if($a->lesson->topic->number === $b->lesson->topic->number) {
                if($a->lesson->number === $b->lesson->number) {
                    return 0;
                }

                return $a->lesson->number < $b->lesson->number ? -1 : 1;
            } 
            
            return $a->lesson->topic->number < $b->lesson->topic->number ? -1 : 1;
        });

        foreach($userlessons as $userlesson) {
            $collection[] = [
                'id' => $userlesson->id,
                'package' => $userlesson->lesson->topic->number . '.' . $userlesson->lesson->number . ' ' . $userlesson->lesson->name,
                'completed' => $userlesson->completed === 1 ? 'Yes' : 'No'
            ];
        }

        return $collection;
    }

    public function index()
    {
        //
    }

    protected function getRecords()
    {
        //
    }
}
