@foreach ($roles as $role)
						
	<div class="is-flex">
		<h5 class="title is-5">{{ \TrainingTracker\Domains\Roles\Role::whereType($role)->first()->name }}</h5>

		@if($user->directlyManagesRole() === \TrainingTracker\Domains\Roles\Role::whereType($role)->first()->type)

			<a 
				href="/users/{{ $user->id }}/reporting/{{ \TrainingTracker\Domains\Roles\Role::whereType($role)->first()->id }}/edit" 
				class="button is-text is-small ml-4"
			>
				Edit
			</a>

		@endif

	</div>

	

	@if (array_key_exists($role, $users) && $users[$role] !== null)

		<ul class="mt-0">
		
			@foreach ($users[$role] as $employee)

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