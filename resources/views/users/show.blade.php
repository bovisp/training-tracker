@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-desktop">
			<h2 class="title is-2">
				{{ trans('app.pages.users.show.profilefor') }} {{ $user->firstname }} {{ $user->lastname }}
			</h2>

			<div class="content">
				<dl>
					<dt>
						<strong>{{ trans('app.pages.users.show.role') }}</strong>
					</dt>

					<dd>
						
						@component('users.components.role', [
							'user' => $user,
							'roles' => \TrainingTracker\Domains\Roles\Role::all()
						])

						@endcomponent
					</dd>

					<dt>
						<strong>{{ trans('app.pages.users.show.email') }}</strong>
					</dt>

					<dd>{{ $user->email }}</dd>

					<dt>
						<strong>{{ trans('app.pages.users.show.active') }}</strong>
					</dt>

					<dd class="is-flex items-center">
						
						@component('users.components.activation', ['user' => $user])

						@endcomponent

					</dd>

					<dt>
						<strong>{{ trans('app.pages.users.show.appointdate') }}</strong>
					</dt>

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
						{{ trans('app.pages.users.show.reporting') }}
					</h3>

					@foreach($roles as $role)

						<div class="is-flex items-center mb-4">
							<h5 class="title is-5 mb-0">{{ $role->name }}</h5>

							@if (moodleauth()->user()->roles->first()->type === 'administrator')

								<a 
									class="button is-text is-small ml-4"
									href="{{ env('APP_URL') }}/users/{{ $user->id }}/reporting/{{ $role->id }}/edit"
								>{{ trans('app.general.buttons.edit') }}</a>

							@endif

						</div>
						
						@if($reporting->where('role', $role->type)->count() > 0)

							<ul class="mt-0">

								@foreach($reporting->where('role', $role->type)->toArray() as $person)

									<li>
										<a href="{{ env('APP_URL') }}/users/{{ $person['id'] }}">
											{{ $person['firstname'] }} {{ $person['lastname'] }}
										</a>
									</li>

								@endforeach

							</ul>

						@else

							<div class="message">
								<div class="message-body">
									{{ trans('app.pages.users.show.norole1') }} "{{ $role->name }}" {{ trans('app.pages.users.show.norole2') }} {{ $role->rank < $user->roles->first()->rank ?  trans('app.pages.users.show.norole3')  :  trans('app.pages.users.show.norole4')  }} {{ $user->moodleuser->firstname }} {{ $user->moodleuser->lastname }}.
								</div>
							</div>

						@endif

					@endforeach

				@endif

				@if ($user->hasUnassignedLessons() && moodleauth()->user()->hasRole('administrator'))

					<div class="divider divider--relaxed"></div>

					<h3 class="title is-3">
						{{ trans('app.pages.users.show.addusassignedlessons') }}
					</h3>

					<unassigned-user-lessons user-id="{{ $user->id }}"></unassigned-user-lessons>

				@endif

				@if ($user->hasLessons())

					<div class="divider divider--relaxed"></div>

					<h3 class="title is-3">
						{{ trans('app.pages.users.show.lessonpackages') }}
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