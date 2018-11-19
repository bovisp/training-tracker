<?php

namespace TrainingTracker\Http\Objectives\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreObjectiveRequest extends FormRequest
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
            'lesson_id' => 'required|integer|min:0|exists:lessons,id',
            'number' => [
                'required',
                'min:1',
                Rule::unique('objectives')->where(function ($query) {
                    $query->where([
                        ['lesson_id', request('lesson_id')]
                    ]);
                })
            ],
            'name_en' => 'required|min:3',
            'name_fr' => 'required|min:3',
            'notebook_required' => 'required|max:1'
        ];
    }

    public function messages()
    {
        return [
            'lesson_id.required' => trans('app.errors.objectives.lessonId.required'),
            'lesson_id.min' => trans('app.errors.objectives.lessonId.min'),
            'lesson_id.exists' => trans('app.errors.objectives.lessonId.exists1') . $this->lesson_id . trans('app.errors.objectives.lessonId.exists2'),
            'lesson_id.integer' => trans('app.errors.objectives.lessonId.integer'),
            'number.required' => trans('app.errors.objectives.number.required'),
            'number.min' => trans('app.errors.objectives.number.min'),
            'number.unique' => trans('app.errors.objectives.number.unique1') . $this->number . trans('app.errors.objectives.number.unique2'),
            'name_en.required' => trans('app.errors.objectives.nameEn.required'),
            'name_en.min' => trans('app.errors.objectives.nameEn.min'),
            'name_fr.required' => trans('app.errors.objectives.nameFr.required'),
            'name_fr.min' => trans('app.errors.objectives.nameFr.min'),
            'notebook_required.required' => trans('app.errors.objectives.notebookRequired.required'),
            'notebook_required.max' => trans('app.errors.objectives.notebookRequired.max')
        ];
    }
}
