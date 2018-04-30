@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-half-desktop">
			<h2 class="title is-2">
				Profile for {{ $user->firstname }} {{ $user->lastname }}
			</h2>

			<div class="content">
				<dl>
					<dt><strong>Role</strong></dt>
					<dd>{{ ucfirst($user->role) }}</dd>

					<dt><strong>Email</strong></dt>
					<dd>{{ $user->email }}</dd>

					<dt><strong>Active</strong></dt>
					<dd>
						{{ $user->active === 1 ? 'Yes' : 'No' }}

						@if (moodleauth()->user()->hasRole('administrator'))

							<a 
								href="/users/{{ $user->id }}/{{ $user->active === 1 ? 'deactivate' : 'activate' }}"
							>
								({{ $user->active === 1 ? 'Deactivate' : 'Activate' }})
							</a>

						@endif

					</dd>
				</dl>
			

				@if (!$user->hasRole('administrator'))

					<div class="divider divider--relaxed"></div>

					<h3 class="title is-3">
						Reporting
					</h3>

					@component('users.components.reporting', [
						'roles' => $user->supervisorRoles(),
						'user' => $user,
						'users' => $user->usersSupervisors()
					])

					@endcomponent

					@component('users.components.reporting', [
						'roles' => $user->employeeRoles(),
						'user' => $user,
						'users' => $user->usersSupervisees()
					])

					@endcomponent

				@endif
			</div>
		</div>
	</div>

@endsection