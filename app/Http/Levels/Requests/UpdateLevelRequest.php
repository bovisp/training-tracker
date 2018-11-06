<?php

namespace TrainingTracker\Http\Levels\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLevelRequest extends FormRequest
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
            'name_en' => 'required|min:3',
            'name_fr' => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'name_en.required' => 'Please enter a level name in English.',
            'name_en.min' => 'The "Name" must be at least three characters long.',
            'name_fr.required' => 'Please enter a level name in French.',
            'name_fr.min' => 'The "Name" must be at least three characters long.'
        ];
    }
}
