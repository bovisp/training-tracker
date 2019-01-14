<?php

namespace TrainingTracker\Http\LogbookEntries\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogbookEntriesStoreRequest extends FormRequest
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
            'body' => 'required|min:20',
            'files' => 'array'
        ];
    }

    public function messages()
    {
        return [
            'body.required' => trans('app.errors.logbookentries.body.required'),
            'body.min' => trans('app.errors.logbookentries.body.min'),
            'files.array' => trans('app.errors.logbookentries.files.array')
        ];       
    }
}
