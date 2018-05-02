@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-desktop">
			<div class="level">
				<div class="level-left">
					<h2 class="title is-2">Inactive users</h2>
				</div>

				<div class="level-right">
					<a href="{{ route('users.index') }}" class="button is-text">
						Active users
					</a>
				</div>
			</div>

			<datatable 
				endpoint="{{ route('inactiveusers.index.api') }}"
				:custom-headers="['id', 'firstname', 'lastname', 'email']"
				:action-button="true"
				action-button-endpoint="/users/"
				action-button-text="Profile"
			>
			</datatable>
		</div>
	</div>

@endsection