<?php

namespace TrainingTracker\Http\LogbookEntries\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\LogbookEntries\Requests\LogbookEntriesStoreRequest;
use TrainingTracker\Http\LogbookEntries\Resources\LogbookEntryResource;

class LogbookEntriesController extends Controller
{
    public function store(LogbookEntriesStoreRequest $request, User $user, Logbook $logbook)
    {
        $logbookEntry = new LogbookEntry;

        $entry = $logbookEntry->add($logbook->userlesson->user, $logbook);

        return response()->json([
            'flash' => trans('app.flash.logbookentryadded'),
            'entry' => $entry->id
        ]);
    }

    public function show(User $user, LogbookEntry $entry)
    {
        return new LogbookEntryResource($entry);
    }

    public function update(User $user, LogbookEntry $entry)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $entry->edit($entry->logbook->userlesson->user);

        return response()->json([
            'flash' => trans('app.flash.logbookentryupdated')
        ]);
    }

    public function destroy(User $user, LogbookEntry $entry)
    {
        $entry->delete();

        return response()->json([
            'flash' => trans('app.flash.logbookentrydeleted')
        ]);
    }
}
