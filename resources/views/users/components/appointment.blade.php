@if (!$user->hasRole('administrator'))

	<appointment-date 
		:user="{{ json_encode($user) }}"
		role="{{ moodleauth()->user()->roles()->first()->type }}"
	></appointment-date>

@endif