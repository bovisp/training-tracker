<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Language Lines
    |--------------------------------------------------------------------------
    |
    | The following translation strings will be used throughout the application.
    | These are sorted by type.
    |
    */

    'general' => [
        'appName' => 'MSC Training Tracker',
        'yes' => 'Yes',
        'no' => 'No',
        'unauthorized' => 'Unauthorized',

        'fields' => [
            'nameen' => 'Name (English)',
            'namefr' => 'Name (French)',
        ],

        'buttons' => [
            'edit' => 'Edit',
            'delete' => 'Delete',
            'add' => 'Add',
            'cancel' => 'Cancel',
            'submit' => 'Submit',
        ],
    ],

    'components' => [
        'comments' => [
            'addedon' => 'added this on:',
            'edited' => 'edited',
            'deletecomment' => 'Are you sure you want to delete this comment?',
            'commentdeleted' => 'Comment successfully deleted.',
            'commentupdated' => 'Comment successfully updated.',
            'nocomments' => 'No comments to display',
            'addcomment' => 'Add new comment',
        ],
    ],

    'pages' => [
        'inactiveusers' => [
            'title' => 'Inactive users',
            'activeuserslink' => 'Active users',
        ],

        'layouts' => [
            'langswitcher' => [
                'english' => 'English',
                'french' => 'French',
                'switchto' => 'Switch to:',
            ],

            'nav' => [
                'menu' => 'Menu',
                'loggedinas' => 'Logged in as ',
                'actions' => 'Actions:',
                'manageusers' => 'Manage users',
                'manageroles' => 'Manage roles',
                'managelevels' => 'Manage levels',
                'managelessons' => 'Manage lessons',
                'manageobjectives' => 'Manage objectives',
                'profile' => 'Profile',
                'returntomoodle' => 'Return to Moodle',
            ],

            'notifications' => [
                'nonotifications' => 'You have no unread notifications',
            ],
        ],

        'lessons' => [
            'fields' => [
                'level' => 'Level',
                'selectlevel' => 'Select a level...',
                'number' => 'Lesson number',
                'periodscovered' => 'Period(s) in which this training should be covered:',
                'period9' => 'Early EG-03 (0-9 months)',
                'period18' => 'Late EG-03 (9-18 months)',
                'period30' => 'Early EG-04 (18-30 months)',
                'period42' => 'Late EG-04 (30-42 months)',
                'depricated' => 'Depricated',
            ],

            'buttons' => [
                'addlesson' => 'Add lesson',
                'updatelesson' => 'Update lesson',
                'deletelesson' => 'Delete lesson',
                'deletethislesson' => 'Delete this lesson',
            ],

            'create' => [
                'title' => 'Add Lesson',
            ],

            'edit' => [
                'title' => 'Edit Lesson',
                'deletemessage1' => 'Are you sure you want to do this? All data associated with this lesson (objectives, user lesson plans etc.) will be permanently deleted. ',
                'deletemessage2' => 'Only do this if you are absolutely sure this is what you want.',
            ],

            'index' => [
                'title' => 'Lessons',
            ],
        ],

        'levels' => [
            'create' => [
                'title' => 'Add levels',
            ],

            'index' => [
                'title' => 'Levels',
            ],

            'edit' => [
                'title' => 'Edit level',
                'deletemessage1' => 'Are you sure you want to do this? All data associated with this level (lessons, objectives, apprentice lesson packages etc.) will be permanently deleted. ',
                'deletemessage2' => 'Only do this if you are absolutely sure this is what you want.',
            ],

            'edit' => [
                'title' => 'Levels',
            ],

            'buttons' => [
                'addlevel' => 'Add level',
                'editlevel' => 'Edit level',
                'deletelevel' => 'Delete level', 
                'deletethislevel' => 'Delete this level',
            ],
        ],

        'logbooks' => [
            'show' => [
                'title' => 'Logbook',
                'backtopackage' => 'Back to lesson package',
                'level' => 'Level: ',
                'lesson' => 'Lesson: ',
                'objective' => 'Objective:',
            ]
        ],

        'notifications' => [
            'for' => 'Notifications for',
        ],

        'objectives' => [
            'create' => [
                'title' => 'Add Objective',
            ],

            'edit' => [
                'title' => 'Edit Objective',
            ],

            'index' => [
                'title' => 'Objectives',
            ],

            'fields' => [
                'lessonnumber' => 'Lesson number',
                'selectlesson' => 'Select a lesson...',
                'objectivenumber' => 'Objective number',
                'logbookrequired' => 'Logbook required',
            ],

            'buttons' => [
                'addobjective' => 'Add objective',
                'editobjective' => 'Edit objective',
            ],
        ],

        'roles' => [
            'create' => [
                'title' => 'Add role',
            ],

            'index' => [
                'title' => 'Roles',
            ],

            'edit' => [
                'title' => 'Edit role',
                'deletemessage1' => 'Are you sure you want to do this? Any users with this role will be immediately denied access to the application. ',
                'deletemessage2' => 'Only do this if you are absolutely sure this is what you want.',
            ],

            'fields' => [
                'type' => 'Type',
                'rank' => 'Rank',
            ],

            'buttons' => [
                'addrole' => 'Add role',
                'editrole' => 'Edit role',
                'deleterole' => 'Delete role',
                'deletethisrole' => 'Delete this role',
            ],
        ],

        'userlessons' => [
            'show' => [
                'level' => 'Level:',
                'lessonpackage' => 'Lesson package:',
                'name' => 'Name:',
                'deletemessage1' => 'Are you sure you want to do this? All data associated with this package (objectives completed, comments, status and logbooks) will be permanently deleted. ',
                'deletemessage2' => 'Only do this if you are absolutely sure this is what you want.',
            ],

            'buttons' => [
                'deletepackage' => 'Delete lesson package',
                'deletethispackage' => 'Delete this lesson package',
            ],
        ],

        'userreporting' => [
            'userreporting' => 'Users successfully linked',
        ],

        'users' => [
            'activation' => [
                'deactivate' => 'Deactivate',
                'activate' => 'Activate',
            ],

            'delete' => [
                'deletemessage1' => 'Are you sure you want to do this? All information about this user will be permenantly deleted. ',
                'deletemessage2' => 'Only do this if you are absolutely sure this is what you want.',
            ],

            'create' => [
                'title' => 'Add users',
                'usersadded' => 'Users successfully added.',
            ],

            'index' => [
                'title' => 'Users',
            ],

            'show' => [
                'profilefor' => 'Profile for',
                'role' => 'Role',
                'email' => 'Email',
                'active' => 'Active',
                'appointdate' => 'Appointment date',
                'reporting' => 'Reporting',
                'norole1' => 'No one with a role of',
                'norole2' => 'currently',
                'norole3' => 'supervises',
                'norole4' => 'works under',
                'addusassignedlessons' => 'Add Unassigned Lesson Packages',
                'lessonpackages' => 'Lesson Packages',
            ],

            'buttons' => [
                'deleteuser' => 'Delete user',
                'deletethisuser' => 'Delete this user',
                'updaterole' => 'Update role',
                'addusers' => 'Add users',
                'inactiveusers' => 'Inactive users',
            ],
        ]
    ],

    'errors' => [
        'general' => [
            'denied' => 'You are not authorized to do that.',
            'notauthenticated' => 'You are not authenticated on Moodle.',
        ],

        'userlessons' => [
            'statusTypes' => 'This is not a valid status type',
            'completed' => 'This lesson package is not complete',
        ],

        'lessons' => [
            'levelId' => [
                'required' => 'Please enter a level.',
                'min' => 'The level id must be greater than 0',
                'exists1' => 'Level ',
                'exists2' => ' does not exist.',
                'integer' => 'The level id must be an integer (i.e. 1, 2, 3 etc.).',
            ],

            'number' => [
                'required' => 'Please enter a lesson number.',
                'unique1' => 'Lesson ',
                'unique2' => ' already exists for topic.',
            ],

            'nameEn' => [
                'required' => 'Please enter a lesson name in English.',
                'min' => 'The "Name" must be at least three characters long.',
            ],

            'nameFr' => [
                'required' => 'Please enter a lesson name in French.',
                'min' => 'The "Name" must be at least three characters long.',
            ],

            'p9' => [
                'integer' => 'The "Early EG-03" period checkbox should have value of 0 or 1.',
                'between' => 'The "Early EG-03" period checkbox should have value of 0 or 1.',
            ],

            'p18' => [
                'integer' => 'The "Late EG-03" period checkbox should have value of 0 or 1.',
                'between' => 'The "Late EG-03" period checkbox should have value of 0 or 1.',
            ],

            'p30' => [
                'integer' => 'The "Early EG-04" period checkbox should have value of 0 or 1.',
                'between' => 'The "Early EG-04" period checkbox should have value of 0 or 1.',
            ],

            'p42' => [
                'integer' => 'The "Late EG-04" period checkbox should have value of 0 or 1.',
                'between' => 'The "Late EG-04" period checkbox should have value of 0 or 1.',
            ],

            'depricated' => [
                'required' => 'Please enter "Yes" for a depricated lesson or "No" for an active one',
                'min' => 'Please enter "Yes" for a depricated lesson or "No" for an active one',
                'integer' => 'Please enter "Yes" for a depricated lesson or "No" for an active one',
            ],
        ],

        'levels' => [
            'nameEn' => [
                'required' => 'Please enter a level name in English.',
                'min' => 'The "Name" must be at least three characters long.',
            ],

            'nameFr' => [
                'required' => 'Please enter a level name in French.',
                'min' => 'The "Name" must be at least three characters long.',
            ],
        ],

        'logbookentries' => [
            'body' => [
                'required' => 'Please add some text to your entry.',
                'min' => 'Your entry must be at least 20 characters long.',
            ],

            'files' => [
                'array' => 'The files you uploaded are not valid.'
            ],
        ],

        'objectives' => [
            'lessonId' => [
                'required' => 'Please enter a lesson number.',
                'min' => 'The lesson number must be greater than 0',
                'exists1' => 'Lesson ',
                'exists2' => ' does not exist.',
                'integer' => 'The lesson number must be an integer (i.e. 1, 2, 3 etc.)',
            ],

            'number' => [
                'required' => 'Please enter an objective number.',
                'min' => 'The objective number must be one or more characters long',
                'unique1' => 'Objective ',
                'unique2' => ' already exists for this lesson.',
            ],

            'nameEn' => [
                'required' => 'Please enter an objective name in English.',
                'min' => 'The "Name" must be at least three characters long.',
            ],

            'nameFr' => [
                'required' => 'Please enter an objective name in French.',
                'min' => 'The "Name" must be at least three characters long.',
            ],

            'notebookRequired' => [
                'required' => 'The "Notebook required" field is required.',
                'max' => 'The "Notebook required" field has an incorrect value.',
            ],
        ],

        'roles' => [
            'type' => [
                'required' => 'Please enter a role type.',
                'min' => 'The "Type" must be at least three characters long.',
                'unique1' => "A role 'Type' with a value of '",
                'unique2' => "' aleady exists.",
            ],

            'rank' => [
                'integer' => 'The "Rank" must be a number',
                'unique1' => "A role with a 'Rank' of '",
                'unique2' => "' aleady exists.",
            ],

            'nameEn' => [
                'required' => 'Please enter a role name in English.',
                'min' => 'The "Name" must be at least three characters long.',
            ],

            'nameFr' => [
                'required' => 'Please enter a role name in French.',
                'min' => 'The "Name" must be at least three characters long.',
            ],
        ],

        'userlessons' => [
            'required' => 'Please enter a lesson number.',
            'min' => 'The lesson number must be greater than 0',
            'exists1' => 'Lesson ',
            'exists2' => ' does not exist.',
            'integer' => 'The lesson number must be an integer (i.e. 1, 2, 3 etc.)',
            'objectives' => 'One or more of the objectives is invalid',
        ],

        'users' => [
            'id' => [
                'required' => 'You have not checked the checkbox next to one or more of your selected users.',
                'exists' => 'The user with an id of :input is not registered on Moodle. Please ask them to register.',
                'unique' => 'The user with an id of :input has already been added to this application.',
            ],

            'role' => [
                'required' => 'You have not added a role for one or more selected users.',
                'exists' => 'The role :input does not exist',
            ],

            'appointedAt' => [
                'required' => 'Please enter a date.',
                'date' => 'Please enter a valid date.',
            ],
        ],

        'usersreporting' => [
            'id' => [
                'required' => 'Please select a user you wish to link.',
                'exists' => 'A user with an id of :input does not exist.',
            ],
        ],

        'usersrole' => [
            'role' => [
                'required' => 'Please enter a role type.',
                'exists1' => "A role 'Type' with a value of '",
                'exists2' => "' does not exist.",
            ],
        ],
    ],

    'datatable' => [
        'label' => [
            'firstname' => 'First name',
            'lastname' => 'Last name',
            'email' => 'E-mail',
            'level' => 'Level',
            'lesson' => 'Lesson',
            'name' => 'Name',
            'depricated' => 'Depricated',
            'objective' => 'Objective',
            'description' => 'Description',
            'type' => 'Type',
            'lessonpackage' => 'Lesson package',
            'completed' => 'Completed',
            'role' => 'Role',
        ],

        'buttons' => [
            'profile' => 'Profile',
            'edit' => 'Edit',
            'view' => 'View',
        ]
    ],

    'flash' => [
        'lessonadded' => 'Lesson successfully added.',
        'lessonupdated' => 'Lesson successfully updated.',
        'lessondeleted' => 'Lesson successfully deleted.',
        'leveladded' => 'Level successfully added.',
        'levelupdated' => 'Level successfully updated.',
        'leveldeleted' => 'Level successfully deleted.',
        'logbookentryadded' => 'Logbook entry successfully created.',
        'logbookentryupdated' => 'Logbook entry successfully updated.',
        'logbookentrydeleted' => 'Logbook entry successfully deleted.',
        'filesupdated' => 'Files successfuly updated.',
        'filedeleted' => 'File successfully deleted.',
        'allnotificationsread' => 'All notifications marked as read.',
        'allreadnotificationsdeleted' => 'All read notifications deleted.',
        'allnotificationsunread' => 'All notifications marked as unread.',
        'allunreadnotificationsdeleted' => 'All unread notifications deleted.',
        'notificationread' => 'Notification marked as read.',
        'notificationunread' => 'Notification marked as unread.',
        'notificationdeleted' => 'Notification successfully deleted.',
        'objectiveadded' => 'Objective successfully added.',
        'objectiveupdated' => 'Objective successfully updated.',
        'objectivedeleted' => 'Objective successfully deleted.',
        'roleadded' => 'Role created successfully.',
        'roleupdated' => 'Role updated successfully.',
        'roledeleted' => 'Role deleted successfully.',
        'unassigneduserlessonadded' => 'Lesson package added successfully.',
        'lessonpackageupdated' => 'Lesson package updated successfully.',
        'lessonpackagedeleted' => 'Lesson package successfully deleted.',
        'usersadded' => 'Users added successfully.',
        'userdeleted' => 'User deleted successfully.',
        'useractivated' => 'User successfully activated.',
        'userdeactivated' => 'User successfully deactivated.',
        'appointmentdateupdated' => 'Date of appointment updated successfully.',
        'usersroleupdated' => 'Role updated successfully.',
    ],
];