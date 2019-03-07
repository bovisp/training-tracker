<?php

namespace TrainingTracker\Http\Logbooks\Controllers\Api;

use Illuminate\Http\Request;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;

class LogbooksController extends Controller
{
    public function index(User $user, UserLesson $userlesson)
    {
        return $userlesson->load(['logbooks', 'logbooks.objective', 'logbooks.entries']);
    }
}
