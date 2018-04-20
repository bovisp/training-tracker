<?php
namespace TrainingTracker\Domains\Users;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use TrainingTracker\App\Traits\HasPermissionsTrait;
use TrainingTracker\App\Traits\HasSupervisorsTrait;
use TrainingTracker\Domains\MoodleUsers\MoodleUser;
use TrainingTracker\Domains\Supervisors\Supervisor;
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
        'moodle_id'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $appends = [
        'firstname', 'lastname', 'email'
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

    /**
     * Get all active employees.
     * 
     * @return model \TrainingTracker\Domains\Users\User
     */
    public static function active()
    {
        return self::with('roles')
            ->select('id')
            ->where('active', 1)
            ->get();
    }

    public static function notIn()
    {
        $employees = self::pluck('moodle_id')->toArray();

        return MoodleUser::select('firstname', 'lastname', 'email', 'id')
            ->where('id', '>', 1)
            ->whereNotIn('id', $employees)
            ->get();
    }

    public static function add($request)
    {
        foreach ($request as $employee) {
            $user = self::create([
                'moodle_id' => MoodleUser::find($employee["id"])->id,
                'active' => 1
            ])->assignRole($employee["role"]);

            if ($user->hasRole('admin')) {
                $user->supervisor()->create([ 'user_id' => $user->id ]);
            }            
        }
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

    protected function moodleProfile($column)
    {
        $user = User::find($this->id);

        return MoodleUser::whereId($user->moodle_id)
            ->first()
            ->{$column};
    }
}