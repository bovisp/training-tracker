<?php

namespace TrainingTracker\Http\UnassignedUserLessons\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnassignedUserLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userlesson' => 'required|integer|min:0|exists:lessons,id'
        ];
    }

    public function messages()
    {
        return [
            'userlesson.required' => 'Please enter a lesson number.',
            'userlesson.min' => 'The lesson number must be greater than 0',
            'userlesson.exists' => "Lesson " . $this->lesson . " does not exist.",
            'userlesson.integer' => 'The lesson number must be an integer (i.e. 1, 2, 3 etc.)'
        ];
    }
}
