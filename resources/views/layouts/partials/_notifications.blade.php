@if (moodleauth()->user()->unreadNotifications->count())
	<div class="navbar-item">
		<a 
			href="{{ route('notifications.index', [ 'user' => moodleauth()->id() ]) }}" 
			title="You have {{ moodleauth()->user()->unreadNotifications->count() }} unread {{ str_plural('notification', moodleauth()->user()->unreadNotifications->count()) }}"
		>
			<div class="icon">
				<i class="mdi mdi-bell has-text-info"></i>
			</div>
		</a>
	</div>

@else

	<div class="navbar-item">
		<a 
			href="{{ route('notifications.index', [ 'user' => moodleauth()->id() ]) }}" 
			title="You have no unread notifications"
		>
			<div class="icon">
				<i class="mdi mdi-bell-off has-text-black"></i>
			</div>
		</a>
	</div>

@endif