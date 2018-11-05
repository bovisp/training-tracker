<?php

namespace TrainingTracker\Http\Logbooks\Controllers;

use Illuminate\Http\Request;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Users\User;

class LogbookController extends Controller
{
    public function show(User $user, Logbook $logbook)
    {
        $logbook->load([
            'objective', 'objective.lesson', 'objective.lesson.topic'
        ]);

        $user->load(['moodleuser']);

        return view('logbooks.show', compact('logbook', 'user'));
    }
}
