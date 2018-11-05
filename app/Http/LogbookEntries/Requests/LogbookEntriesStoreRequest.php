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
            'body.required' => 'Please add some text to your entry.',
            'body.min' => 'Your entry must be at least 20 characters long.',
            'files.array' => 'The files you uploaded are not valid'
        ];       
    }
}
