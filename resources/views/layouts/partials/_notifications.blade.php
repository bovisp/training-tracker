@if (moodleauth()->user()->unreadNotifications->count())
	<a href="/users/{{ moodleauth()->id() }}/notifications">Notifications</a>
@endif