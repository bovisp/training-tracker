<?php

namespace TrainingTracker\Http\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
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
            '*.id' => 'required|exists:mysql2.mdl_user,id|unique:users,moodle_id',
            '*.role' => 'required|exists:roles,type'
        ];
    }

    public function messages()
    {
        return [
            '*.id.required' => 'You have not checked the checkbox next to one or more of your selected users.',
            '*.id.exists' => 'The user with an id of :input is not registered on Moodle. Please ask them to register.',
            '*.id.unique' => 'The user with an id of :input has already been added to this application.',
            '*.role.required' => 'You have not added a role for one or more selected users.',
            '*.role.exists' => 'The role :input does not exist'
        ];
    }
}