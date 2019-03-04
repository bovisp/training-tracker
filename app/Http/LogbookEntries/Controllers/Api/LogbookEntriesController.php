<?php

namespace TrainingTracker\Http\LogbookEntries\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Http\LogbookEntries\Requests\LogbookEntriesStoreRequest;
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

    public function store(LogbookEntriesStoreRequest $request, Logbook $logbook)
    {
        // if ($logbook->userlesson->completed === 1) {
        //     return response()->json([
        //         'errors' => [
        //             'errors' => 'You cannot do this as the lesson package has been marked as complete.'
        //         ]
        //     ], 403);
        // }
        
        $logbookEntry = new LogbookEntry;

        $entry = $logbookEntry->add($logbook->userlesson->user, $logbook);

        return response()->json([
            'flash' => trans('app.flash.logbookentryadded'),
            'entry' => $entry->id
        ]);
    }

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

    public function destroy(LogbookEntry $entry)
    {
        $entry->delete();

        return response()->json([
            'flash' => trans('app.flash.logbookentrydeleted')
        ]);
    }
}
