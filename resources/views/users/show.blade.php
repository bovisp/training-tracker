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
					<dd>
						
						@component('users.components.role', [
							'user' => $user,
							'roles' => \TrainingTracker\Domains\Roles\Role::all()
						])

						@endcomponent
					</dd>

					<dt><strong>Email</strong></dt>
					<dd>{{ $user->email }}</dd>

					<dt><strong>Active</strong></dt>
					<dd class="is-flex items-center">
						
						@component('users.components.activation', ['user' => $user])

						@endcomponent

					</dd>

					<dt><strong>Appointment date</strong></dt>
					<dd class="is-flex items-center">

						@if (!$user->hasRole('administrator'))

							<appointment-date :user="{{ json_encode($user) }}"></appointment-date>

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
						'users' => $user->usersSupervisors($user)
					])

					@endcomponent

					@component('users.components.reporting', [
						'roles' => $user->employeeRoles(),
						'user' => $user,
						'users' => $user->usersSupervisees($user)
					])

					@endcomponent

				@endif

				<div class="divider divider--relaxed"></div>

				@component('users.components.delete', ['user' => $user])

				@endcomponent
			</div>
		</div>
	</div>

@endsection