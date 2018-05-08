<?php

namespace TrainingTracker\Http\Objectives\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreObjectiveRequest extends FormRequest
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
            'lesson_id' => 'required|integer|min:0|exists:lessons,id',
            'number' => [
                'required',
                'min:1',
                Rule::unique('objectives')->where(function ($query) {
                    $query->where([
                        ['lesson_id', request('lesson_id')]
                    ]);
                })
            ],
            'name_en' => 'required|min:3',
            'name_fr' => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'lesson_id.required' => 'Please enter a lesson number.',
            'lesson_id.min' => 'The lesson number must be greater than 0',
            'lesson_id.exists' => "Lesson " . $this->lesson_id . " does not exist.",
            'lesson_id.integer' => 'The lesson number must be an integer (i.e. 1, 2, 3 etc.)',
            'number.required' => 'Please enter an objective number.',
            'number.min' => 'The objective number must be one or more characters long',
            'number.unique' => "Objective " . $this->number . " already exists for this lesson.",
            'name_en.required' => 'Please enter an objective name in English.',
            'name_en.min' => 'The "Name" must be at least three characters long.',
            'name_fr.required' => 'Please enter an objective name in French.',
            'name_fr.min' => 'The "Name" must be at least three characters long.'
        ];
    }
}
