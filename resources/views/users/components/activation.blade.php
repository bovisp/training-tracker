{{ $user->active === 1 ? 'Yes' : 'No' }}

@if (moodleauth()->user()->hasRole('administrator'))

	<form action="/users/{{ $user->id }}/activation" method="POST">
		@if ($user->active)
			{{ method_field('DELETE') }}
		@endif

		{{ csrf_field() }}

		<button class="button is-text">
			({{ $user->active === 1 ? 'Deactivate' : 'Activate' }})
		</button>
	</form>

@endif