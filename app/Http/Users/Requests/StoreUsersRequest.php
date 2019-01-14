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
            '*.id.required' => trans('app.errors.users.id.required'),
            '*.id.exists' => trans('app.errors.users.id.exists'),
            '*.id.unique' => trans('app.errors.users.id.unique'),
            '*.role.required' => trans('app.errors.users.role.required'),
            '*.role.exists' => trans('app.errors.users.role.exists')
        ];
    }
}