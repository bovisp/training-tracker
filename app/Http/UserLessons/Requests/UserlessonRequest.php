<?php

namespace TrainingTracker\Http\UserLessons\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TrainingTracker\Domains\Objectives\Objective;
use Illuminate\Validation\Rule;

class UserlessonRequest extends FormRequest
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
            'statuses.*' => [
                'nullable',
                Rule::in(['c', 'd', 'e']),
                function ($attribute, $value, $fail) {
                    $userlessonComments = $this->userlesson->comments->count();

                    if ($value === 'c' && $userlessonComments === 0) {
                        $fail("A supervisor or head of operations has not yet entered a Statement of Competency.");
                    }
                },
            ],
            'completedObjectives.*' => [
                'exists:objectives,id',
                function ($attribute, $value, $fail) {
                    $logbook = $this->userlesson->logbooks->where('objective_id', $value)->first();
                    $requiresEntry = (Objective::find($value))->notebook_required;
                    $entries = optional($logbook)->entries;

                    if ($entries !== null && $entries->count() === 0 && $requiresEntry) {
                        $fail("The objective {$logbook->objective->name} does not yet have a logbook entry");
                    }
                },
                function ($attribute, $value, $fail) {
                    $logbook = $this->userlesson->logbooks->where('objective_id', $value)->first();
                    $requiresEntry = (Objective::find($value))->notebook_required;
                    $entries = optional($logbook)->entries;

                    if ($entries !== null && $entries->count() !== 0 && $requiresEntry) {
                        $entriesWithComments = $entries->filter(function ($entry) {
                            return $entry->comments
                                ->filter(function ($comment) {
                                    return $comment->user->hasRole(['supervisor', 'head_of_operations', 'administrator']);
                                })
                                ->count() > 0;
                        });

                        if (count($entriesWithComments) === 0) {
                            $fail("No logbook associated with the objective '{$logbook->objective->name}' has a comment by a Supervisor or Head of Operations.");
                        }
                    }
                }
            ]
        ];
    }
}
