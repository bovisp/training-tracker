<?php

namespace TrainingTracker\Http\LogbookEntries\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Http\LogbookEntries\Resources\LogbookEntryResource;

class LogbookEntriesController extends Controller
{
    // public function index(User $user, Logbook $logbook)
    // {
    //     return LogbookEntriesResource::collection($logbook->entries)
    //         ->additional([
    //             'completedPackage' => $logbook->userlesson->completed
    //         ]);
    // }

    // public function store(LogbookEntriesStoreRequest $request, User $user, Logbook $logbook)
    // {
    //     if ($logbook->userlesson->completed === 1) {
    //         return response()->json([
    //             'errors' => [
    //                 'errors' => 'You cannot do this as the lesson package has been marked as complete.'
    //             ]
    //         ], 403);
    //     }
        
    //     $logbookEntry = new LogbookEntry;

    //     $logbookEntry->add($user, $logbook);

    //     return response()->json([
    //         'flash' => trans('app.flash.logbookentryadded')
    //     ]);
    // }

    public function show(LogbookEntry $entry)
    {
        return new LogbookEntryResource($entry);
    }

    public function update(LogbookEntry $entry)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $entry->edit($entry->logbook->userlesson->user);

        return response()->json([
            'flash' => trans('app.flash.logbookentryupdated')
        ]);
    }

    // public function destroy(User $user, Logbook $logbook, LogbookEntry $logbookEntry)
    // {
    //     $logbookEntry->delete();

    //     return response()->json([
    //         'flash' => trans('app.flash.logbookentrydeleted')
    //     ]);
    // }
}
