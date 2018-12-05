<?php

namespace TrainingTracker\Domains\LogbookEntry;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;

class LogbookEntryObserver
{
	public function updating(LogbookEntry $logbookEntry)
	{
		$logbookEntry->edited_at = Carbon::now();
        $logbookEntry->edited_by = moodleauth()->id();
	}

	public function deleting(LogbookEntry $logbookEntry)
	{
		// Delete all associated notifications for this entry
		$test = DB::table('notifications')
			->where('data','LIKE','%"logbookEntryId":' . $logbookEntry->id . '%')
			->delete();

		// Delete all comments associated with a userlesson
		$logbookEntry->comments->each->delete();

		if ($logbookEntry->files !== null) {
			// Delete all files associated with an entry.
			$files = unserialize($logbookEntry->files);

	        foreach ($files as $file) {
	            $filePath = '/public/entries/' . $logbookentry->logbook->userlesson->user->id . '/' . $file['codedFilename'];

	            Storage::delete($filePath);
	        }
		}
	}
}