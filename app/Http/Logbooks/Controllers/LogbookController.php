<?php

namespace TrainingTracker\Http\Logbooks\Controllers;

use Illuminate\Http\Request;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Users\User;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
    public function edit(Logbook $logbook)
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
    public function update(Request $request, Logbook $logbook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \TrainingTracker\Logbook  $logbook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logbook $logbook)
    {
        //
    }
}
