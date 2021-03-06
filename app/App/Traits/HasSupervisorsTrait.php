<?php

namespace TrainingTracker\App\Traits;

use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\Users\User;

trait HasSupervisorsTrait
{
    protected $employeeArr = [];

    protected $supervisorArr = [];

    public function supervisor()
    {
        return $this->hasOne(Supervisor::class);
    }

    public function supervisors()
    {
        return $this->belongsToMany(Supervisor::class, 'users_supervisors');
    }

    public function reportingStructure()
    {
        if ($this->hasAnyReportingStructure() === true) {
            return collect();
        }

        if (optional($this->supervisors)->count() === 0) {
            $this->getEmployees();

            return collect($this->employeeArr);
        }

        if (optional($this->supervisor)->users === null) {
            $this->getSupervisors();

            return collect($this->supervisorArr);
        }

        $this->getEmployees();

        $this->getSupervisors();

        return collect($this->supervisorArr)->merge(collect($this->employeeArr));
    }

    protected function getEmployees()
    {
        $employees = $this->supervisor->users->load('moodleuser', 'roles');

        $this->mappedEmployees($employees);
    }

    protected function getSupervisors()
    {
        $supervisors = $this->supervisors->each->load('user.moodleuser', 'user.roles');

        $this->mappedSupervisors($supervisors);
    }

    protected function hasAnyReportingStructure()
    {
        return optional($this->supervisors)->count() === 0 && optional($this->supervisor)->users === null;
    }

    protected function mappedEmployees($employees)
    {
        foreach ($employees as $employee) {
            $this->employeeArr[] = $this->getEmployeeMeta($employee);

            if (optional($employee->supervisor)->users !== null) {
                $this->mappedEmployees($employee->supervisor->users->load('moodleuser', 'roles'));
            }
        }
    }

    protected function mappedSupervisors($supervisors)
    {
        foreach ($supervisors as $supervisor) {
            $this->supervisorArr[] = $this->getSupervisorMeta($supervisor);

            if (optional($supervisor->user)->supervisors !== null) {
                $this->mappedSupervisors($supervisor->user->supervisors->each->load('user.moodleuser', 'user.roles'));
            }
        }
    }

    protected function getEmployeeMeta($employee)
    {
        return [
            'id' => $employee->id, 
            'role' => $employee->roles[0]->type, 
            'rank' => $employee->roles[0]->rank,
            'firstname' => $employee->moodleuser->firstname, 
            'lastname' => $employee->moodleuser->lastname
        ];
    }

    protected function getSupervisorMeta($supervisor)
    {
        return [
            'id' => $supervisor->user_id, 
            'role' => $supervisor->user->roles[0]->type, 
            'rank' => $supervisor->user->roles[0]->rank, 
            'firstname' => $supervisor->user->moodleuser->firstname, 
            'lastname' => $supervisor->user->moodleuser->lastname
        ];
    }

    public function supervisorsAndHeadOfOperationsRoles(User $user) {
        return User::find(
            $user->reportingStructure()
                ->map(function ($u) use ($user) {
                    if (($u['role'] === 'supervisor' || $u['role'] === 'head_of_operations') && ($u['id'] !== moodleauth()->id())) {
                        return $u['id'];
                    }
                })
                ->toArray()
        );
    }
}