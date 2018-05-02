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
            'role.required' => 'Please enter a role type.',
            'role.exists' => "A role 'Type' with a value of '" . $this->role . "' does not exist."
        ];
    }
}
