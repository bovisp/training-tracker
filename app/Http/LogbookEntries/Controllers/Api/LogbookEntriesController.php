<?php

namespace TrainingTracker\Http\LogbookEntries\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\App\Notifications\LogbookEntryAdded;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\LogbookEntries\Resources\LogbookEntriesResource;

class LogbookEntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Logbook $logbook)
    {
        return LogbookEntriesResource::collection($logbook->entries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        // $logbookEntry->load([
        //     'logbook', 'creator.moodleuser', 'logbook.userlesson', 'logbook.objective', 'logbook.userlesson.lesson', 'logbook.userlesson.lesson.topic'
        // ]);

        $users = User::find(
            $user->reportingStructure()
                ->map(function ($u) {
                    if ($u['role'] === 'supervisor' || $u['role'] === 'head_of_operations') {
                        return $u['id'];
                    }
                })
                ->toArray()
        );

        Notification::send($users, new LogbookEntryAdded($logbookEntry, $user->id));

        return response()->json([
            'flash' => 'Logbook entry successfully created.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \TrainingTracker\Logbook  $logbook
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Logbook $logbook)
    {
        $logbook->load(['objective', 'objective.lesson', 'objective.lesson.topic']);

        $user->load(['moodleuser']);

        return view('logbooks.show', compact('logbook', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \TrainingTracker\Logbook  $logbook
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \TrainingTracker\Logbook  $logbook
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Logbook $logbook, LogbookEntry $logbookEntry)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $logbookEntry->update([
            'body' => request('body')
        ]);

        return (new LogbookEntriesResource($logbookEntry))
            ->additional([
                'flash' => 'Logbook entry successfully updated.'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \TrainingTracker\Logbook  $logbook
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Logbook $logbook, LogbookEntry $logbookEntry)
    {
        $logbookEntry->delete();

        return response()->json([
            'flash' => 'Logbook entry successfully deleted.'
        ]);
    }
}
