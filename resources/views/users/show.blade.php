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

							<appointment-date 
								:user="{{ json_encode($user) }}"
								role="{{ moodleauth()->user()->roles()->first()->type }}"
							></appointment-date>

						@endif
						
					</dd>
				</dl>
			

				@if (!$user->hasRole('administrator'))

					<div class="divider divider--relaxed"></div>

					<h3 class="title is-3">
						Reporting
					</h3>

					@foreach($roles as $role)

						<div class="is-flex items-center mb-4">
							<h5 class="title is-5 mb-0">{{ $role->name }}</h5>

							@if (moodleauth()->user()->roles->first()->type === 'administrator')

								<a 
									class="button is-text is-small ml-4"
									href="/users/{{ $user->id }}/reporting/{{ $role->id }}/edit"
								>Edit</a>

							@endif

						</div>
						
						@if($reporting->where('role', $role->type)->count() > 0)

							<ul class="mt-0">

								@foreach($reporting->where('role', $role->type)->toArray() as $person)

									<li>
										<a href="/users/{{ $person['id'] }}">
											{{ $person['firstname'] }} {{ $person['lastname'] }}
										</a>
									</li>

								@endforeach

							</ul>

						@else

							<div class="message">
								<div class="message-body">
									No one with a role of "{{ $role->name }}" currently {{ $role->rank < $user->roles->first()->rank ? 'supervises' : 'works under' }} {{ $user->moodleuser->firstname }} {{ $user->moodleuser->lastname }}.
								</div>
							</div>

						@endif

					@endforeach

					{{-- @component('users.components.reporting', [
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

					@endcomponent --}}

				@endif

				@if ($user->hasUnassignedLessons() && moodleauth()->user()->hasRole('administrator'))

					<div class="divider divider--relaxed"></div>

					<h3 class="title is-3">
						Add Unassigned Lesson Packages
					</h3>

					<unassigned-user-lessons user-id="{{ $user->id }}"></unassigned-user-lessons>

				@endif

				@if ($user->hasLessons())

					<div class="divider divider--relaxed"></div>

					<h3 class="title is-3">
						Lesson Packages
					</h3>

					@component('users.components.lesson-packages', ['user' => $user])

					@endcomponent

				@endif

				<div class="divider divider--relaxed"></div>

				@component('users.components.delete', ['user' => $user])

				@endcomponent
			</div>
		</div>
	</div>

@endsection