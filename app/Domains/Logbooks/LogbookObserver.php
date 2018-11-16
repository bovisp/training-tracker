<?php

namespace TrainingTracker\Domains\Logbook;

use TrainingTracker\Domains\Logbooks\Logbook;

class LogbookObserver
{
	public function deleting(Logbook $logbook)
	{
		// Delete all entries associated with a logbook
		$logbook->entries->each->delete();
	}
}