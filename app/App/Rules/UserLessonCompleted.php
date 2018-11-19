<?php

namespace TrainingTracker\App\Rules;

use Illuminate\Contracts\Validation\Rule;
use TrainingTracker\Domains\UserLessons\UserLesson;

class UserLessonCompleted implements Rule
{
    protected $userlesson;

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
        if ($value === 1 ) {
            return $this->completedStatus() && 
                   $this->completedObjectives() && 
                   $this->completedNotebooks() &&
                   $this->completedEvaluation();
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
        return trans('app.errors.userlessons.completed');
    }

    protected function completedStatus() {
        foreach ($this->statusPeriods as $statusPeriod) {
            if ($this->userlesson->{$statusPeriod} === 'c') {
                return true;
            }
        }

        return false;
    }

    protected function completedObjectives() {
        $completedObjectives = $this->userlesson->user->objectives->pluck('id')->toArray();
        $totalObjectives = $this->userlesson->lesson->objectives->pluck('id')->toArray();

        usort($completedObjectives, function ($a, $b) {
            return $this->arrSort($a, $b);
        });

        usort($totalObjectives, function ($a, $b) {
            return $this->arrSort($a, $b);
        });

        return $totalObjectives === $completedObjectives;
    }

    protected function completedNotebooks() {
        $this->userlesson
            ->logbooks
            ->each(function ($logbook) {
                if ($logbook->entries->count() === 0) {
                    return false;
                }
            });

        return true;
    }

    protected function completedEvaluation()
    {
        return $this->userlesson->comments->count() >= 1;
    }

    protected function arrSort($a, $b) {
        if ($a == $b) {
            return 0;
        }
        
        return ($a < $b) ? -1 : 1;
    }
}