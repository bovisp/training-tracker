@if (moodleauth()->user()->unreadNotifications->count())
	<a href="{{ env('APP_URL') }}/users/{{ moodleauth()->id() }}/notifications">Notifications</a>
@endif