<?php

namespace TrainingTracker\App\Classes;

use TrainingTracker\Domains\Config\Config;
use TrainingTracker\Domains\MoodleUsers\MoodleUser;
use TrainingTracker\Domains\Sessions\Session;
use TrainingTracker\Domains\Users\User;

/**
 * Provides a set of helper methods to extract information about an
 * authenticated Moodle user.
 */
class Auth
{
    /**
     * The Moodle cookie as it appears in the browser.
     * 
     * @var string
     */
	protected $browserCookie;

    /**
     * The Moodle cookie stored in the Moodle mdl_sessions table of the
     * currently logged in user. 
     * 
     * @var string
     */
	protected $cookie;

    /**
     * The Moodle id stored in the Moodle mdl_sessions table of the currently
     * logged in user.
     *     
     * @var string
     */
	protected $moodleId;

    /**
     * The constructor function of the class.
     */
	public function __construct()
	{
		$session = new Session;

		$this->browserCookie = $_COOKIE['MoodleSessionDev'] ?? '';
		$this->cookie = optional($session->cookie($this->browserCookie))->sid;
		$this->moodleId = optional($session->cookie($this->browserCookie))->userid;
	}

    /**
     * Check if a user is currently authenticated on Moodle.
     * 
     * @return boolean If true then a user is authenticated on Moodle.
     */
	public function check()
    {
        return $this->status();
    }

    /**
     * Checks if a Moodle cookie exists in the browser and matches a Moodle
     * cookie in the mdl_sessions Moodle table. As long as the Moodle user id
     * in the extracted mdl_session table does not equal zero, the user's Moodle
     * browser cookie is valid and they are logged into Moodle.
     * 
     * @return boolean If true then a user is authenticated on Moodle.
     */
    public function status()
    {
    	if (! $this->browserCookie) {
            return false;
        }

        return $this->authenticated();
    }

    /**
     * Checks if a Moodle cookie in the browser matches a Moodle cookie in the 
     * mdl_sessions Moodle table. As long as the Moodle user id in the extracted 
     * mdl_session table does not equal zero, the user's Moodle browser cookie
     * is valid and they are logged into Moodle.
     * 
     * @return boolean If true then a user is authenticated on Moodle.
     */
    protected function authenticated()
    {
        return ($this->cookie === $this->browserCookie)
            && $this->moodleId !== 0;
    }

    /**
     * Checks if the currently logged in Moodle user is also a Moodle site
     * administrator.
     * 
     * @return boolean If true then an authenticated Moodle user is also a site
     * administrator.
     */
    public function admin()
    {
        if (! $this->check()) {
            return false;
        }

        // If the logged in user's Moodle ID is not equal to the value of the
        // siteadmins Moodle id in the mdl_sessions table, then the current
        // user is not an admin.
        $config = new Config;

        if ($this->moodleId !== $config->adminId()) {
            return false;
        }

        return true;
    }

    /**
     * Returns a subset of the currently logged in Moodle user's profile
     * information such as their Moodle id, first name, last name and email.
     * 
     * @return object \TrainingTracker\Domains\MoodleUsers\MoodleUser
     */
    public function moodleuser()
    {
        if (! $this->check()) {
            return '';
        }

        $user = new MoodleUser;

        return $user->profile($this->moodleId);
    }

    public function user()
    {
        if (! $this->check()) {
            return '';
        }

        return User::where('moodle_id', $this->moodleid())
            ->get()
            ->first();
    }

    public function id()
    {
        return $this->user()->id;
    }

    /**
     * Returns the id of the currently logged in Moodle user.
     * 
     * @return string The id of the currently logged in Moodle user.
     */
    public function moodleid()
    {
        if (! $this->check()) {
            return '';
        }

        $user = new MoodleUser;

        return $user->profile($this->moodleId)->id;
    }
}