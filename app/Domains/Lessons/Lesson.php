<?php

namespace TrainingTracker\Domains\Lessons;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use TrainingTracker\Domains\Levels\Level;
use TrainingTracker\Domains\Objectives\Objective;
use TrainingTracker\Domains\UserLessons\UserLesson;

class Lesson extends Model
{
    use HasTranslations;

    protected $translatable = ['name'];

    protected $fillable = [
        'level_id', 'name', 'number', 'depricated', 'p9', 'p18', 'p30', 'p42'
    ];

    public function level()
    {
    	return $this->belongsTo(Level::class);
    }

    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }

    public function userlessons()
    {
        return $this->hasMany(UserLesson::class);
    }

    public function add()
    {
        self::create([
            'level_id' => request('level_id'),
            'number' => request('number'),
            'name' => [
                'en' => request('name_en'),
                'fr' => request('name_fr')
            ],
            'p9' => request()->has('p9') ? request('p9') : 0,
            'p18' => request()->has('p18') ? request('p18') : 0,
            'p30' => request()->has('p30') ? request('p30') : 0,
            'p42' => request()->has('p40') ? request('p40') : 0,
        ]);
    }

    public function edit()
    {
        $this->update([
            'level_id' => request('level_id'),
            'number' => request('number'),
            'name' => [
                'en' => request('name_en'),
                'fr' => request('name_fr')
            ],
            'depricated' => request('depricated'),
            'p9' => request()->has('p9') ? request('p9') : 0,
            'p18' => request()->has('p18') ? request('p18') : 0,
            'p30' => request()->has('p30') ? request('p30') : 0,
            'p42' => request()->has('p40') ? request('p40') : 0,
        ]);
    }

    public function toArray()
    {
        $attributes = parent::toArray();
        
        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }
        
        return $attributes;
    }
}
