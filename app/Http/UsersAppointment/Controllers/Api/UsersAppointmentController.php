<?php

namespace TrainingTracker\Http\UsersAppointment\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\Users\Requests\UpdateAppointmentUserRequest;

class UsersAppointmentController extends Controller
{
    public function update(UpdateAppointmentUserRequest $request, User $user)
    {
        $user->update([
            'appointed_at' => request('appointed_at')
        ]);

        return response()->json([
            'flash' => 'Date of appointment updated successfully.',
            'date' => $user->appointed_at
        ]);
    }
}
