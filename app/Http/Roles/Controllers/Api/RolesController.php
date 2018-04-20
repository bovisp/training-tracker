<?php

namespace TrainingTracker\Http\Roles\Controllers\Api;

use TrainingTracker\App\Controllers\DatatablesController;
use TrainingTracker\Domains\Roles\Role;

class RolesController extends DatatablesController
{
    public function builder()
    {
        return Role::query();
    }

    public function getDisplayableColumns()
    {
    	return ['id', 'type', 'name'];
    }
}
