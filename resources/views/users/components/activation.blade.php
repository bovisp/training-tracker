{{ $user->active === 1 ? trans('app.general.yes') : trans('app.general.no') }}

@if (moodleauth()->user()->hasRole('administrator'))

	<form action="{{ env('APP_URL') }}/users/{{ $user->id }}/activation" method="POST">
		@if ($user->active)
			{{ method_field('DELETE') }}
		@endif

		{{ csrf_field() }}

		<button class="button is-text is-small">
			{{ $user->active === 1 ? trans('app.pages.users.activation.deactivate') : trans('app.pages.users.activation.activate') }}
		</button>
	</form>

@endif