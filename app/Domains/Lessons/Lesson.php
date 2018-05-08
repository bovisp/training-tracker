<?php

namespace TrainingTracker\Domains\Lessons;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use TrainingTracker\Domains\Objectives\Objective;
use TrainingTracker\Domains\Topics\Topic;
use TrainingTracker\Domains\UserLessons\UserLesson;

class Lesson extends Model
{
    use HasTranslations;

    protected $translatable = ['name'];

    protected $fillable = ['topic_id', 'name', 'number', 'depricated'];

    public function topic()
    {
    	return $this->belongsTo(Topic::class);
    }

    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }

    public function userlessons()
    {
        return $this->hasMany(UserLesson::class);
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
