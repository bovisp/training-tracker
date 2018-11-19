<?php

namespace TrainingTracker\Http\UnassignedUserLessons\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnassignedUserLessonRequest extends FormRequest
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
            'userlesson' => 'required|integer|min:0|exists:lessons,id'
        ];
    }

    public function messages()
    {
        return [
            'userlesson.required' => trans('app.errors.userlessons.required'),
            'userlesson.min' => trans('app.errors.userlessons.min'),
            'userlesson.exists' => trans('app.errors.userlessons.exists1') . $this->lesson . trans('app.errors.userlessons.exists2'),
            'userlesson.integer' => trans('app.errors.userlessons.integer')
        ];
    }
}
