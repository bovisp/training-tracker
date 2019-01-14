<?php

namespace TrainingTracker\Http\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentUserRequest extends FormRequest
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
            'appointed_at' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'appointed_at.required' => trans('app.errors.users.appointedAt.required'),
            'appointed_at.date' => trans('app.errors.users.appointedAt.date')
        ];
    }
}
