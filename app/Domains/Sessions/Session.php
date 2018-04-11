<?php

namespace TrainingTracker\Domains\Sessions;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
	protected $table = "mdl_sessions";

    protected $connection = 'mysql2';

    public function cookie($browserCookie)
    {
        return $this->select('sid', 'userid')->where('sid', '=', $browserCookie)->first();
    }
}