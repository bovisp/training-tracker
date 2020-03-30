<?php

namespace TrainingTracker\App\Rules;

use Illuminate\Contracts\Validation\Rule;
use TrainingTracker\Domains\UserLessons\UserLesson;

class UserLessonCompleted implements Rule
{
    protected $userlesson;

    protected $errors = [];

    protected $statusPeriods = ['p9', 'p18', 'p30', 'p42'];

    public function __construct(UserLesson $userlesson)
    {
        $this->userlesson = $userlesson;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ((int) $value === 1 ) {
            return $this->completedStatus() && 
                    $this->completedObjectives() &&
                    $this->completedEvaluation() &&
                    $this->completedComments();
        }
        
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('app.errors.userlessons.completed') . ' ' . $this->errors[0];
    }

    protected function completedStatus() {
        foreach ($this->statusPeriods as $statusPeriod) {
            if ($this->userlesson->{$statusPeriod} === 'c') {
                return true;
            }
        }

        $this->errors[] = 'There is not a \'c\' status in any of the four status periods';

        return false;
    }

    protected function completedObjectives() {
        $completedObjectives = $this->userlesson->user->objectives->pluck('id')->toArray();
        $totalObjectives = $this->userlesson->lesson->objectives->pluck('id')->toArray();

        $objectivesDifference = array_filter($totalObjectives, function ($objective) use ($completedObjectives) {
            return !in_array($objective, $completedObjectives);
        });

        if (count($objectivesDifference) === 0) {
            return true;
        }

        $this->errors[] = 'One or more objectives has not been marked as complete.';

        return false;
    }

    protected function completedNotebooks() {
        $this->userlesson
            ->logbooks
            ->each(function ($logbook) {
                if ($logbook->entries->count() === 0) {
                    $this->errors[] = 'Logbook ' . $logbook->objective->number . ' needs to have at least one entry.';

                    return false;
                }
            });

        return true;
    }

    protected function completedEvaluation()
    {
        if ($this->userlesson->comments->count() >= 1) {
            return true;
        }

        $this->errors[] = 'There are no entries for Statement of Competency.';

        return false;
    }

    protected function completedComments()
    {
        $this->userlesson
            ->logbooks
            ->each(function ($logbook) {
                $logbook->entries->each(function ($entry) {
                    $entry->comments->each(function ($comment) use ($entry) {
                        if ($comment->user->hasRole(['supervisor', 'head_of_operations', 'administrator'])) {
                            $this->commentsCount += 1;
                        }
                    });
                });

                if ($this->commentsCount === 0) {                    
                    $this->errors[] = 'There are no comments by any Supervisor or Head of Operations in any of the logbook entries pertaining to the objective ' . $logbook->objective->number . '.';
                }

                $this->commentsCount = 0;
            });

        if (!empty($this->errors)) {
            return false;
        }

        return true;
    }
}