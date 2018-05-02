<?php

namespace TrainingTracker\Domains\Topics;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Topic extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
    
    protected $fillable = ['name', 'number'];

    public function toArray()
    {
        $attributes = parent::toArray();
        
        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }
        
        return $attributes;
    }
}
