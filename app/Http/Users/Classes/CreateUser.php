<?php

namespace TrainingTracker\Http\Users\Classes;

use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Objectives\Objective;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;

class CreateUser
{
	public function add()
    {
        foreach (request()->all() as $newUser) {
            $user = $this->persist($newUser);

            $this->addToSupervisors($user);

            $this->persistApprenticeData($user);
        }
    }

    protected function persist($newUser)
    {
        return User::create([
            'moodle_id' => $newUser["id"]
        ])->assignRole($newUser["role"]);
    }

    protected function addToSupervisors(User $user)
    {
        if ($user->hasRole(['manager', 'head_of_operations', 'supervisor'])) {
            Supervisor::create([ 
                'user_id' => $user->id 
            ]);
        }
    }

    protected function persistApprenticeData(User $user)
    {
        if ($user->hasRole('apprentice')) {
            $this->createUserLessonPackages($user);
        }
    }

    protected function createUserLessonPackages(User $user)
    {
        foreach (Lesson::whereDepricated(0)->get() as $lesson) {
            $userlesson = UserLesson::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id
            ]);

            $this->createLogbooks($lesson, $userlesson);
        }
    }

    protected function createLogbooks(Lesson $lesson, UserLesson $userlesson)
    {
        $lesson->objectives->each(function ($objective) use ($userlesson) {
            $this->createLogbook($objective, $userlesson);
        });
    }

    protected function createLogbook(Objective $objective, UserLesson $userlesson)
    {
        if ($objective->notebook_required === 1) {
            Logbook::create([
                'objective_id' => $objective->id,
                'userlesson_id' => $userlesson->id
            ]);
        }
    }
}