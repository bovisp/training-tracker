<?php

namespace TrainingTracker\Http\LogbookEntries\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
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
        request()->validate([
            'file' => 'required|file|mimes:jpeg,bmp,png,pdf,doc,docx,ppt,pptx,xls,xlsx'
        ]);

        $upload = request()->file('file');

        $extension = strtolower(explode('.', request()->file('file')->getClientOriginalName())[1]);

        Storage::putFileAs(
            "/public/entries/{$user->id}", $upload, request('id') . '.' . $extension
        );

        return [
            'codedFilename' => request('id') . '.' . $upload->getClientOriginalExtension(),
            'actualFilename' => request()->file('file')->getClientOriginalName()
        ];
    }

    public function update(User $user, LogbookEntry $logbookEntry)
    {
        $filesArr = unserialize($logbookEntry->files);

        foreach (request('files') as $file) {
            array_push($filesArr, $file);
        }

        $logbookEntry->update([
            'files' => serialize($filesArr)
        ]);

        return response()->json([
            'flash' => 'Files successfult updated.'
        ]);
    }

    public function download(User $user, $file)
    {
        $pathToFile = "/public/entries/{$user->id}/{$file}";

        return Storage::download($pathToFile);
    }

    public function destroy(User $user, LogbookEntry $logbookEntry, $file)
    {
        $pathToFile = "/public/entries/{$user->id}/{$file}";

        Storage::delete($pathToFile);

        $filesArr = $this->removeElementWithValue(
            unserialize($logbookEntry->files), 'codedFilename', $file
        );

        $logbookEntry->update([
            'files' => serialize($filesArr)
        ]);

        return response()->json([
            'flash' => 'File successfully deleted.'
        ]);
    }

    protected function removeElementWithValue($array, $key, $value){
        foreach($array as $subKey => $subArray){
            if($subArray[$key] == $value){
                unset($array[$subKey]);
            }
        }

        return $array;
    }
}
