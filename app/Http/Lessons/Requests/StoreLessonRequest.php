<?php

namespace TrainingTracker\Http\Lessons\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLessonRequest extends FormRequest
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
            'level_id' => 'required|integer|min:0|exists:levels,id',
            'number' => [
                'required',
                Rule::unique('lessons')->where(function ($query) {
                    $query->where([
                        ['level_id', request('level_id')],
                        ['depricated', 0]
                    ]);
                })
            ],
            'name_en' => 'required|min:3',
            'name_fr' => 'required|min:3',
            'p9' => 'integer|between:0,1',
            'p18' => 'integer|between:0,1',
            'p30' => 'integer|between:0,1',
            'p42' => 'integer|between:0,1'
        ];
    }

    public function messages()
    {
        return [
            'level_id.required' => 'Please enter a level name.',
            'level_id.min' => 'The level id must be greater than 0',
            'level_id.exists' => "Level " . $this->level_id . " does not exist.",
            'level_id.integer' => 'The level id must be an integer (i.e. 1, 2, 3 etc.)',
            'number.required' => 'Please enter a lesson number.',
            'number.unique' => "Lesson " . $this->number . " already exists for topic.",
            'name_en.required' => 'Please enter a lesson name in English.',
            'name_en.min' => 'The "Name" must be at least three characters long.',
            'name_fr.required' => 'Please enter a lesson name in French.',
            'name_fr.min' => 'The "Name" must be at least three characters long.',
            'p9.integer' => 'The "Early EG-03" period checkbox should have value of 0 or 1.',
            'p9.between' => 'The "Early EG-03" period checkbox should have value of 0 or 1.',
            'p18.integer' => 'The "Late EG-03" period checkbox should have value of 0 or 1.',
            'p18.between' => 'The "Late EG-03" period checkbox should have value of 0 or 1.',
            'p30.integer' => 'The "Early EG-04" period checkbox should have value of 0 or 1.',
            'p30.between' => 'The "Early EG-04" period checkbox should have value of 0 or 1.',
            'p42.integer' => 'The "Late EG-04" period checkbox should have value of 0 or 1.',
            'p42.between' => 'The "Late EG-04" period checkbox should have value of 0 or 1.'
        ];
    }
}
