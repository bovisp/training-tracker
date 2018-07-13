<?php
namespace TrainingTracker\Domains\Users;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use TrainingTracker\App\Traits\HasPermissionsTrait;
use TrainingTracker\App\Traits\HasSupervisorsTrait;
use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\MoodleUsers\MoodleUser;
use TrainingTracker\Domains\Objectives\Objective;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;

class User extends Authenticatable
{
    use Notifiable, HasPermissionsTrait, HasSupervisorsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'moodle_id', 'active', 'appointed_at'
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

    public function supervisor()
    {
        return $this->hasOne(Supervisor::class);
    }

    public function moodleuser()
    {
        return $this->hasOne(MoodleUser::class, 'id', 'moodle_id')
            ->select('firstname', 'lastname', 'email', 'id');
    }

    public function userlessons()
    {
        return $this->hasMany(UserLesson::class);
    }

    /**
     * Get all active employees.
     * 
     * @return model \TrainingTracker\Domains\Users\User
     */
    public static function active()
    {
        return self::select('id')
            ->where('active', 1)
            ->get();
    }

    public static function inactive()
    {
        return self::select('id')
            ->where('active', 0)
            ->get();
    }

    public static function notIn()
    {
        $employees = self::pluck('moodle_id')->toArray();

        return MoodleUser::select('id', 'firstname', 'lastname', 'email')
            ->where('id', '>', 1)
            ->whereNotIn('id', $employees)
            ->get();
    }

    public function hasLessons()
    {
        return $this->userlessons()->count() > 0;
    }

    public function getUnassignedUserLessons()
    {
        $result = [];

        $unassignedNonDepricatedLessonIds = array_values(
            array_diff(
                Lesson::whereDepricated(0)
                    ->pluck('id')
                    ->toArray(), 
                UserLesson::whereUserId($this->id)
                    ->pluck('lesson_id')
                    ->toArray()
            )
        );

        $unassignedDepricatedLessonIds = array_values(
            array_diff(
                Lesson::whereDepricated(1)
                    ->pluck('id')
                    ->toArray(), 
                UserLesson::whereUserId($this->id)
                    ->pluck('lesson_id')
                    ->toArray()
            )
        );

        if (count($unassignedNonDepricatedLessonIds)) {
            $unassignedNonDepricatedLessons = 
                Lesson::whereIn('id', $unassignedNonDepricatedLessonIds)
                    ->with('topic')
                    ->get();

            $result['non_depricated'] = $unassignedNonDepricatedLessons;
        }

        if (count($unassignedDepricatedLessonIds)) {
            $unassignedDepricatedLessons = 
                Lesson::whereIn('id', $unassignedDepricatedLessonIds)
                    ->with('topic')
                    ->get();

            $result['depricated'] = $unassignedDepricatedLessons;
        }

        return $result;
    }

    public function hasUnassignedLessons()
    {
        if (!$this->hasLessons()) {
            return false;
        }

        return count($this->getUnassignedUserLessons()) > 0;
    }

    public function objectives()
    {
        return $this->belongsToMany(Objective::class, 'users_objectives');
    }

    public function completedObjectives()
    {
        return $this->objectives()
            ->pluck('objective_id')
            ->toArray();
    }

    public function updateObjectives($allObjectives, $newobjectives)
    {
        $this->objectives()->detach($allObjectives);

        $this->objectives()->attach($newobjectives);
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
}