<?php

use Illuminate\Database\Seeder;
use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\Levels\Level;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Objectives\Objective;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;

class DatabaseSeeder extends Seeder
{
	protected $lessons = [];

	protected $users = [];

	protected $roles = [
		'manager', 'head_of_operations', 'supervisor', 'apprentice'
	];

    public function run()
    {
        factory(Level::class, 2)->create()->each(function ($level) {
        	factory(Lesson::class, 2)->create([
        		'level_id' => $level->id,
        		'number' => $level->id . '.' . rand(1, 20)
        	])
        	->each(function ($lesson) {
        		factory(Objective::class, 2)->create([
	        		'lesson_id' => $lesson->id
	        	]);
        	});
        });

        for ($i=3; $i < 24; $i++) { 
        	$user = $this->persist($i);

            $this->addToSupervisors($user);

            $this->persistApprenticeData($user);
        }
    }

    protected function persist($newUser)
    {
        return User::create([
            'moodle_id' => $newUser
        ])->assignRole(array_random($this->roles));
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

            $this->createLogbooks($lesson, $userlesson, $user);
        }
    }

    protected function createLogbooks(Lesson $lesson, UserLesson $userlesson, User $user)
    {
        $lesson->objectives->each(function ($objective) use ($userlesson, $user) {
            $this->createLogbook($objective, $userlesson, $user);
        });
    }

    protected function createLogbook(Objective $objective, UserLesson $userlesson, User $user)
    {
        if ($objective->notebook_required === 1) {
            $logbook = Logbook::create([
                'objective_id' => $objective->id,
                'userlesson_id' => $userlesson->id
            ]);

            $this->createLogbookEntries($user, $logbook);
        }
    }

    protected function createLogbookEntries(User $user, Logbook $logbook)
    {
    	for ($i=0; $i < 2; $i++) { 
    		$logbookEntry = LogbookEntry::create([
                'body' => 'This is a cool entry',
	            'logbook_id' => $logbook->id,
	            'user_id' => $user->id,
            ]);

            $this->createLogbookEntryComments($user, $logbookEntry);
    	}
    }

    protected function createLogbookEntryComments(User $user, LogbookEntry $logbookEntry)
    {
    	for ($i=0; $i < 2; $i++) { 
    		$comment = $logbookEntry->comments()->make([
	            'body' => 'This is my cool comment'
	        ]);

	        $user->comments()->save($comment);
    	}
    }
}
