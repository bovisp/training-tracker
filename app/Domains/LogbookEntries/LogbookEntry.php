<?php

namespace TrainingTracker\Domains\LogbookEntries;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use TrainingTracker\App\Notifications\LogbookEntryCommentNotification;
use TrainingTracker\App\Notifications\LogbookEntryCreatedNotification;
use TrainingTracker\App\Notifications\LogbookEntryEditedNotification;
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
        'creator',
        'comments'
    ];

    public function logbook()
    {
    	return $this->belongsTo(Logbook::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc');
    }

    public function add(User $user, Logbook $logbook)
    {
        $logbookEntry = self::create([
            'body' => request('body'),
            'logbook_id' => $logbook->id,
            'user_id' => moodleauth()->id(),
            'files' => serialize(request('files'))
        ]);

        $users = $user->supervisorsAndHeadOfOperationsRoles($user);

        Notification::send(
            $users, 
            new LogbookEntryCreatedNotification(
                $logbookEntry, 'logbook_entry_added'
            )
        );

        return $logbookEntry;
    }

    public function edit(User $user)
    {
        $this->update([
            'body' => request('body'),
            'edited_by' => moodleauth()->id()
        ]);

        $users = $user->supervisorsAndHeadOfOperationsRoles($user);

        Notification::send(
            $users, 
            new LogbookEntryEditedNotification(
                $this, 'logbook_entry_updated'
            )
        );
    }

    public function addComment(User $user)
    {
        $comment = $this->comments()->make([
            'body' => request('body')
        ]);

        moodleauth()->user()->comments()->save($comment);

        $users = $user->supervisorsAndHeadOfOperationsRoles($user);

        if (moodleauth()->user()->hasRole(['supervisor', 'head_of_operations', 'administrator'])) {
            $users->prepend($user);
        }

        Notification::send(
            $users, 
            new LogbookEntryCommentNotification(
                $comment, 'logbook_entry_comment_added'
            )
        );

        return $comment;
    }

    public function updateComment(Comment $comment, User $user)
    {
        $comment->update([
            'body' => request('body')
        ]);

        $users = $user->supervisorsAndHeadOfOperationsRoles($user);

        Notification::send(
            $users, 
            new LogbookEntryCommentNotification(
                $comment, 'logbook_entry_comment_updated'
            )
        );

        return $comment;
    }
}
