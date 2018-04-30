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
						<a 
							href="/users/{{ $user->id }}/{{ $user->active === 1 ? 'deactivate' : 'activate' }}"
						>
							({{ $user->active === 1 ? 'Deactivate' : 'Activate' }})
						</a>
					</dd>
				</dl>
			

				@if (!$user->hasRole('administrator'))

					<div class="divider divider--relaxed"></div>

					<h3 class="title is-3">
						Reporting
					</h3>

					@foreach ($user->supervisorRoles() as $role)
						
						<div class="is-flex">
							<h5 class="title is-5">{{ \TrainingTracker\Domains\Roles\Role::whereType($role)->first()->name }}</h5>

							<a 
								href="/users/{{ $user->id }}/reporting/{{ \TrainingTracker\Domains\Roles\Role::whereType($role)->first()->id }}/edit" 
								class="tag is-link ml-4"
							>
								Edit
							</a>
						</div>

						

						@if (array_key_exists($role, $user->usersSupervisors()))

							<ul class="mt-0">
							
								@foreach ($user->usersSupervisors()[$role] as $supervisor)

									<li>
										<a href="/users/{{ $supervisor['id'] }}">
											{{ $supervisor["name"] }}
										</a>
									</li>

								@endforeach

							</ul>

						@else

							<div class="message">
								<div class="message-body">
									{{ $user->firstname }} {{ $user->lastname }} currently does not have anybody in this role.
								</div>
							</div>

						@endif

					@endforeach

					@foreach ($user->employeeRoles() as $role)
						
						<div class="is-flex">
							<h5 class="title is-5">{{ \TrainingTracker\Domains\Roles\Role::whereType($role)->first()->name }}</h5>

							<a 
								href="/users/{{ $user->id }}/reporting/{{ \TrainingTracker\Domains\Roles\Role::whereType($role)->first()->id }}/edit" 
								class="tag is-link ml-4"
							>
								Edit
							</a>
						</div>

						

						@if (array_key_exists($role, $user->usersSupervisees()))

							<ul class="mt-0">
							
								@foreach ($user->usersSupervisees()[$role] as $employee)

									<li>
										<a href="/users/{{ $employee['id'] }}">
											{{ $employee["name"] }}
										</a>
									</li>

								@endforeach

							</ul>

						@else

							<div class="message">
								<div class="message-body">
									{{ $user->firstname }} {{ $user->lastname }} currently does not have anybody in this role.
								</div>
							</div>

						@endif

					@endforeach

				@endif
			</div>
		</div>
	</div>

@endsection