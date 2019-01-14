<?php

namespace TrainingTracker\Http\LogbookEntries\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\App\Notifications\LogbookEntryNotification;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\LogbookEntries\Requests\LogbookEntriesStoreRequest;
use TrainingTracker\Http\LogbookEntries\Resources\LogbookEntriesResource;

class LogbookEntriesController extends Controller
{
    public function index(User $user, Logbook $logbook)
    {
        return LogbookEntriesResource::collection($logbook->entries)
            ->additional([
                'completedPackage' => $logbook->userlesson->completed
            ]);
    }

    public function store(LogbookEntriesStoreRequest $request, User $user, Logbook $logbook)
    {
        if ($logbook->userlesson->completed === 1) {
            return response()->json([
                'errors' => [
                    'errors' => 'You cannot do this as the lesson package has been marked as complete.'
                ]
            ], 403);
        }
        
        $logbookEntry = new LogbookEntry;

        $logbookEntry->add($user, $logbook);

        return response()->json([
            'flash' => trans('app.flash.logbookentryadded')
        ]);
    }

    public function show(User $user, Logbook $logbook)
    {
        $logbook->load([
            'objective', 'objective.lesson', 'objective.lesson.level', 'userlesson'
        ]);

        $user->load(['moodleuser']);

        return view('logbooks.show', compact('logbook', 'user'));
    }

    public function update(User $user, Logbook $logbook, LogbookEntry $logbookEntry)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $logbookEntry->edit($user);

        return (new LogbookEntriesResource($logbookEntry))
            ->additional([
                'flash' => trans('app.flash.logbookentryupdated')
            ]);
    }

    public function destroy(User $user, Logbook $logbook, LogbookEntry $logbookEntry)
    {
        $logbookEntry->delete();

        return response()->json([
            'flash' => trans('app.flash.logbookentrydeleted')
        ]);
    }
}
