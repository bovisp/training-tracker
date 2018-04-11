<?php

namespace TrainingTracker\App\Classes;

use TrainingTracker\Domains\MoodleUsers\MoodleUser;
use TrainingTracker\Domains\Config\Config;
use TrainingTracker\Domains\Sessions\Session;

class Auth
{
	protected $browserCookie;

	protected $cookie;

	protected $moodleId;

	public function __construct()
	{
		$session = new Session;

		$this->browserCookie = $_COOKIE['MoodleSession'] ?? '';
		$this->cookie = $session->cookie($this->browserCookie)->sid;
		$this->moodleId = $session->cookie($this->browserCookie)->userid;
	}

	public function check()
    {
        return $this->status();
    }

    public function status()
    {
    	if (! $this->browserCookie) {
            return false;
        }

        return $this->authenticated();
    }

    protected function authenticated()
    {
        return ($this->cookie === $this->browserCookie)
            && $this->moodleId !== 0;
    }

    public function admin()
    {
        if (! $this->check()) {
            return false;
        }

        // If the logged in user's Moodle ID is not equal to the value of the
        // siteadmins Moodle ID in the mdl_sessions table, then the current
        // user is not an admin.
        $config = new Config;

        if ($this->moodleId !== $config->adminId()) {
            return false;
        }

        return true;
    }

    public function user()
    {
        if (! $this->check()) {
            return '';
        }

        $user = new MoodleUser;

        return $user->profile($this->moodleId);
    }

    public function id()
    {
        if (! $this->check()) {
            return '';
        }

        $user = new MoodleUser;

        return $user->profile($this->moodleId)->id;
    }
}