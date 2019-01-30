<?php

namespace TrainingTracker\Domains\Deactivation;

use Illuminate\Database\Eloquent\Model;
use TrainingTracker\Domains\Users\User;

class Deactivation extends Model
{
	protected $guarded = [];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}