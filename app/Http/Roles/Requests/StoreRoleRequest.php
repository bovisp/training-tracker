<?php

namespace TrainingTracker\Http\Roles\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'type' => 'required|min:3|unique:roles,type',
            'rank' => 'sometimes|integer|unique:roles,rank',
            'name_en' => 'required|min:3',
            'name_fr' => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => trans('app.errors.roles.type.required'),
            'type.min' => trans('app.errors.roles.type.min'),
            'type.unique' => trans('app.errors.roles.type.unique1') . $this->type . trans('app.errors.roles.type.unique2'),
            'rank.integer' => trans('app.errors.roles.rank.integer'),
            'rank.unique' => trans('app.errors.roles.rank.unique1') . $this->rank . trans('app.errors.roles.rank.unique2'),
            'name_en.required' => trans('app.errors.roles.nameEn.required'),
            'name_en.min' => trans('app.errors.roles.nameEn.min'),
            'name_fr.required' => trans('app.errors.roles.nameFr.required'),
            'name_fr.min' => trans('app.errors.roles.nameFr.min')
        ];
    }
}
