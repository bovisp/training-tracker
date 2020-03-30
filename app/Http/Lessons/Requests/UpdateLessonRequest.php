<?php

namespace TrainingTracker\Http\Lessons\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
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
            'level_id' => 'required|integer|min:0|exists:levels,id',
            'number' => 'required',
            'name_en' => 'required|min:3',
            'name_fr' => 'required|min:3',
            'depricated' => 'required|integer|min:0|max:1',
            'p9' => 'integer|between:0,1',
            'p18' => 'integer|between:0,1',
            'p30' => 'integer|between:0,1',
            'p42' => 'integer|between:0,1'
        ];
    }

    public function messages()
    {
        return [
            'level_id.required' => trans('app.errors.lessons.levelId.required'),
            'level_id.min' => trans('app.errors.lessons.levelId.min'),
            'level_id.exists' => trans('app.errors.lessons.levelId.exists1') . $this->level_id . trans('app.errors.lessons.levelId.exists2'),
            'level_id.integer' => trans('app.errors.lessons.levelId.integer'),
            'number.required' => trans('app.errors.lessons.number.required'),
            'name_en.required' => trans('app.errors.lessons.nameEn.required'),
            'name_en.min' => trans('app.errors.lessons.nameEn.min'),
            'name_fr.required' => trans('app.errors.lessons.nameFr.required'),
            'name_fr.min' => trans('app.errors.lessons.nameFr.min'),
            'depricated.required' => trans('app.errors.lessons.depricated.required'),
            'depricated.min' => trans('app.errors.lessons.depricated.min'),
            'depricated.integer' => trans('app.errors.lessons.depricated.integer'),
            'p9.integer' => trans('app.errors.lessons.p9.integer'),
            'p9.between' => trans('app.errors.lessons.p9.between'),
            'p18.integer' => trans('app.errors.lessons.p18.integer'),
            'p18.between' => trans('app.errors.lessons.p18.between'),
            'p30.integer' => trans('app.errors.lessons.p30.integer'),
            'p30.between' => trans('app.errors.lessons.p30.between'),
            'p42.integer' => trans('app.errors.lessons.p42.integer'),
            'p42.between' => trans('app.errors.lessons.p42.between')
        ];
    }
}
