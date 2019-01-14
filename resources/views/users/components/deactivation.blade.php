@if (!$user->hasRole('administrator'))

	<deactivation 
		:user="{{ json_encode($user) }}"
		role="{{ moodleauth()->user()->roles()->first()->type }}"
	></deactivation>

@endif