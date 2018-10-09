<?php

namespace TrainingTracker\Domains\LogbookEntries;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use TrainingTracker\Domains\Comments\Comment;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Users\User;

class LogbookEntry extends Model
{
	protected $connection = 'mysql';

    protected $table = 'logbookentries';

    protected $fillable = [
    	'logbook_id',
    	'body',
        'user_id',
        'files'
    ];

    protected $dates = [
        'edited_at'
    ];

    protected $with = [
        'editor',
        'creator'
    ];

    public static function boot()
    {
        parent::boot();

        static::updating(function ($logbookEntry) {
            $logbookEntry->edited_at = Carbon::now();
            $logbookEntry->edited_by = moodleauth()->id();
        });

        static::deleting(function ($logbookentry) {
            $files = unserialize($logbookentry->files);

            foreach ($files as $file) {
                $filePath = '/public/entries/' . $logbookentry->logbook->userlesson->user->id . '/' . $file['codedFilename'];

                Storage::delete($filePath);
            }
        });
    }

    public function logbook()
    {
    	return $this->belongsTo(Logbook::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc');
    }
}
