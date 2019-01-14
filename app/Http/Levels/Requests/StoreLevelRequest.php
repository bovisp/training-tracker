<?php

namespace TrainingTracker\Http\Levels\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLevelRequest extends FormRequest
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
            'name_en' => 'required|min:3',
            'name_fr' => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'name_en.required' => trans('app.errors.levels.nameEn.required'),
            'name_en.min' => trans('app.errors.levels.nameEn.min'),
            'name_fr.required' => trans('app.errors.levels.nameFr.required'),
            'name_fr.min' => trans('app.errors.levels.nameFr.min')
        ];
    }
}
