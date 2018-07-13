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

    public function getUserLesson(User $user, UserLesson $userlesson)
    {
        $userlesson = $userlesson->whereId($userlesson->id)
            ->with('lesson.topic')
            ->first();

        $user = $user->whereId($user->id)
            ->with('moodleuser')
            ->first();

        return [
            'userlesson' => [
                'id' => $userlesson->id,
                'lesson' => $userlesson->lesson,
                'topic' => $userlesson->lesson->topic,
                'status' => [
                    'p9' => $userlesson->p9,
                    'p18' => $userlesson->p18,
                    'p30' => $userlesson->p30,
                    'p42' => $userlesson->p42
                ],
                'objectives' => $userlesson->lesson->objectives,
                'notebooks' => ($userlesson->lesson->objectives)->where('notebook_required', 1),
                'completedObjectives' => $user->completedObjectives()
            ],
            'user' => [
                'id' => $user->id,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname
            ]
        ];
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
                'package' => $userlesson->lesson->topic->number . '.' . str_pad($userlesson->lesson->number, 2, '0', STR_PAD_LEFT) . ' ' . $userlesson->lesson->name,
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
