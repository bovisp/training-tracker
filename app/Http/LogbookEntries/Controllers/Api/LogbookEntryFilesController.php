<?php

namespace TrainingTracker\Http\LogbookEntries\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Users\User;

class LogbookEntryFilesController extends Controller
{
    public function meta(User $user, Logbook $logbook)
    {
        return uniqid(true);
    }

    public function upload(User $user, Logbook $logbook)
    {
        $upload = request()->file('file');

        $extension = strtolower(explode('.', request()->file('file')->getClientOriginalName())[1]);

        Storage::putFileAs(
            "/public/entries/{$user->id}", $upload, request('id') . '.' . $extension
        );

        return "request('id').{$upload->getClientOriginalExtension()}";
    }

    public function download(User $user, $file)
    {
        $pathToFile = "/public/entries/{$user->id}/{$file}";

        return Storage::download($pathToFile);
    }
}
