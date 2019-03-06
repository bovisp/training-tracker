<?php

namespace TrainingTracker\Domains\Logbooks;

use Illuminate\Database\Eloquent\Model;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\Objectives\Objective;
use TrainingTracker\Domains\UserLessons\UserLesson;

class Logbook extends Model
{
    protected $fillable = [
    	'objective_id',
    	'userlesson_id'
    ];

    protected $appends = [ 
    	'lastEntryUpdate',
    	'lastEntryUpdateExists',
    	'lastEntryCreated' 
    ];

    public function objective()
    {
    	return $this->belongsTo(Objective::class);
    }

    public function userlesson()
    {
    	return $this->belongsTo(UserLesson::class, 'userlesson_id');
    }

    public function entries()
    {
    	return $this->hasMany(LogbookEntry::class)
            ->select('id', 'logbook_id', 'updated_at', 'user_id', 'created_at', 'edited_at', 'edited_by')
    		->orderBy('created_at', 'asc');
    }

    public function getLastEntryUpdateAttribute()
    {
    	return $this->entries
    		->sortByDesc('edited_at')
    		->first();
    }

    public function getLastEntryUpdateExistsAttribute()
    {
    	return $this->entries
    		->filter(function ($entry) {
    			return $entry->edited_at !== null;
    		})
    		->count();
    }

    public function getLastEntryCreatedAttribute()
    {
    	return $this->entries
    		->sortByDesc('created_at')
    		->first();
    }
}
