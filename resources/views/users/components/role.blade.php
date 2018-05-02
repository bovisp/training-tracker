@if (moodleauth()->user()->hasRole('administrator'))

	<form action="/users/{{$user->id}}/role" method="POST">
		{{ method_field('PUT') }}

		{{ csrf_field() }}

		<div class="field is-grouped">
			<div class="control">
				<div class="select is-small">
					<select name="role">

						@foreach($roles as $role)

							<option 
								value="{{ $role->type }}"

								@if($user->roles()->first()->type === $role->type)
									selected="selected"
								@endif
							>
								{{ $role->name }}
							</option>

						@endforeach

					</select>
				</div>
			</div>

			<div class="control">
				<button class="button is-text is-small">Update role</button>
			</div>
		</div>
	</form>

@else

	{{ ucfirst(str_replace("_", " ", $user->role)) }}

@endif