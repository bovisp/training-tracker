<?php

namespace TrainingTracker\Http\LogbookEntries\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\App\Notifications\LogbookEntryNotification;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\LogbookEntries\Resources\LogbookEntriesResource;

class LogbookEntriesController extends Controller
{
    public function index(User $user, Logbook $logbook)
    {
        return LogbookEntriesResource::collection($logbook->entries);
    }

    public function store(User $user, Logbook $logbook)
    {
        request()->validate([
            'body' => 'required',
            'files' => 'array'
        ]);

        $logbookEntry = LogbookEntry::create([
            'body' => request('body'),
            'logbook_id' => $logbook->id,
            'user_id' => moodleauth()->id(),
            'files' => serialize(request('files'))
        ]);

        $users = $this->getSupervisorsAndHeadOfOperationsRoles($user);

        Notification::send($users, new LogbookEntryNotification($logbookEntry, $user->id, 'logbook_entry_added'));

        return response()->json([
            'flash' => 'Logbook entry successfully created.'
        ]);
    }

    public function show(User $user, Logbook $logbook)
    {
        $logbook->load(['objective', 'objective.lesson', 'objective.lesson.topic']);

        $user->load(['moodleuser']);

        return view('logbooks.show', compact('logbook', 'user'));
    }

    public function update(User $user, Logbook $logbook, LogbookEntry $logbookEntry)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $logbookEntry->update([
            'body' => request('body')
        ]);

        $users = $this->getSupervisorsAndHeadOfOperationsRoles($user);

        Notification::send($users, new LogbookEntryNotification($logbookEntry, $user->id, 'logbook_entry_updated'));

        return (new LogbookEntriesResource($logbookEntry))
            ->additional([
                'flash' => 'Logbook entry successfully updated.'
            ]);
    }

    public function destroy(User $user, Logbook $logbook, LogbookEntry $logbookEntry)
    {
        $logbookEntry->delete();

        return response()->json([
            'flash' => 'Logbook entry successfully deleted.'
        ]);
    }

    protected function getSupervisorsAndHeadOfOperationsRoles(User $user) {
        return User::find(
            $user->reportingStructure()
                ->map(function ($u) {
                    if ($u['role'] === 'supervisor' || $u['role'] === 'head_of_operations') {
                        return $u['id'];
                    }
                })
                ->toArray()
        );
    }
}
