<?php

namespace TrainingTracker\Http\Topics\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
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
            'number' => 'required|integer|unique:topics,number|min:0',
            'name_en' => 'required|min:3',
            'name_fr' => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'number.required' => 'Please enter a topic number.',
            'number.min' => 'The topic number must be greater than 0',
            'number.unique' => "Topic " . $this->number . " aleady exists.",
            'number.integer' => 'The topic number must be an integer (i.e. 1, 2, 3 etc.)',
            'name_en.required' => 'Please enter a topic name in English.',
            'name_en.min' => 'The "Name" must be at least three characters long.',
            'name_fr.required' => 'Please enter a topic name in French.',
            'name_fr.min' => 'The "Name" must be at least three characters long.'
        ];
    }
}
