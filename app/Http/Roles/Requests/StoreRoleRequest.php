<?php

namespace TrainingTracker\Http\Roles\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'type' => 'required|min:3|unique:roles,type',
            'rank' => 'integer|unique:roles,rank',
            'name_en' => 'required|min:3',
            'name_fr' => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Please enter a role type.',
            'type.min' => 'The "Type" must be at least three characters long.',
            'type.unique' => "A role 'Type' with a value of '" . $this->type . "' aleady exists.",
            'rank.integer' => 'The "Rank" must be a number',
            'rank.unique' => "A role with a 'Rank' of '" . $this->rank . "' aleady exists.",
            'name_en.required' => 'Please enter a role name in English.',
            'name_en.min' => 'The "Name" must be at least three characters long.',
            'name_fr.required' => 'Please enter a role name in French.',
            'name_fr.min' => 'The "Name" must be at least three characters long.'
        ];
    }
}
