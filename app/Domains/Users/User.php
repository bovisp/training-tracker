<?php
namespace TrainingTracker\Domains\Users;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use TrainingTracker\App\Traits\HasObjectivesTrait;
use TrainingTracker\App\Traits\HasPermissionsTrait;
use TrainingTracker\App\Traits\HasSupervisorsTrait;
use TrainingTracker\App\Traits\HasUserLessonsTrait;
use TrainingTracker\Domains\Comments\Comment;
use TrainingTracker\Domains\Deactivation\Deactivation;
use TrainingTracker\Domains\MoodleUsers\MoodleUser;
use TrainingTracker\Domains\Users\User;

class User extends Authenticatable
{
    use Notifiable,
        HasPermissionsTrait,
        HasSupervisorsTrait,
        HasUserLessonsTrait,
        HasObjectivesTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'moodle_id',
        'active',
        'appointed_at',
        'deactivated_at',
        'reactivated_at',
        'deactivation_rationale'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'isSupervised', 'canSupervise'
    ];

    protected $appends = [
        'firstname', 'lastname', 'email', 'role'
    ];

    protected $casts = [
        'appointed_at' => 'datetime:d/m/Y',
    ];

    protected $with = [
        'roles'
    ];

    public function moodleuser()
    {
        return $this->hasOne(MoodleUser::class, 'id', 'moodle_id')
            ->select('firstname', 'lastname', 'email', 'id');
    }

    public function deactivations()
    {
        return $this->hasMany(Deactivation::class)
            ->latest('deactivated_at');
    }

    public static function notIn()
    {
        $employees = self::pluck('moodle_id')->toArray();

        return MoodleUser::select('id', 'firstname', 'lastname', 'email')
            ->where('id', '>', 1)
            ->whereNotIn('id', $employees)
            ->get();
    }    

    public function getFirstnameAttribute()
    {
        return $this->moodleProfile('firstname');
    }

    public function getLastnameAttribute()
    {
        return $this->moodleProfile('lastname');
    }

    public function getEmailAttribute()
    {
        return $this->moodleProfile('email');
    }

    public function getRoleAttribute()
    {
        return $this->roles()->first()->type;
    }

    protected function moodleProfile($column)
    {
        $user = User::find($this->id);

        return MoodleUser::whereId($user->moodle_id)
            ->first()
            ->{$column};
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}