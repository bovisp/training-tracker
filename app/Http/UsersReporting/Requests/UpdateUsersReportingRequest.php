<?php

namespace TrainingTracker\Http\UsersReporting\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersReportingRequest extends FormRequest
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
            '*.id' => 'required|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            '*.id.required' => 'Please select a user you wish to link.',
            '*.id.exists' => 'A user with an id of :input does not exist.'
        ];
    }
}