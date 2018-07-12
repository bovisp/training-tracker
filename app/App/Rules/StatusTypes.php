<?php

namespace TrainingTracker\App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StatusTypes implements Rule
{
    protected $statusTypes = ['c', 'd', 'e'];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value === null || in_array($value, $this->statusTypes);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This is not a valid status type';
    }
}