<?php

namespace TrainingTracker\Domains\Config;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
	protected $table = "mdl_config";

	protected $connection = 'mysql2';

	public function adminId()
    {
        return (int)($this->select('value')
            ->where('name', 'siteadmins')
            ->first())->value;
    }
}