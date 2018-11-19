<?php

namespace TrainingTracker\App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StatusTypes implements Rule
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

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
        return $this->value === null || in_array($this->value, $this->statusTypes);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('app.errors.userlessons.statusTypes');
    }
}