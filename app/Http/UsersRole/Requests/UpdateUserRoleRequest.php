<?php

namespace TrainingTracker\Http\UsersRole\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRoleRequest extends FormRequest
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
            'role' => 'required|exists:roles,type'
        ];
    }

    public function messages()
    {
        return [
            'role.required' => trans('app.errors.usersrole.role.required'),
            'role.exists' => trans('app.errors.usersrole.role.exists1') . $this->role . trans('app.errors.usersrole.role.exists2')
        ];
    }
}
