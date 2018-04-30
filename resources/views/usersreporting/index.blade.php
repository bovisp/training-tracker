@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-half-desktop">
			<h2 class="title is-2">
				Edit {{ $role->name }} for 
				{{ $user->moodleuser->firstname }} 
				{{ $user->moodleuser->lastname }}
			</h2>

			<user-errors></user-errors>

			<datatable 
				endpoint="{{ route('usersreporting.index.api', ['user' => $user->id, 'role' => $role->id]) }}"
				redirect-endpoint="{{ route('users.show', ['user' => $user->id]) }}"
				:custom-headers="['id', 'firstname', 'lastname']"
				:has-checkbox="true"
				success-message="Users successfully added"
				post-endpoint="{{ route('usersreporting.store.api', ['user' => $user->id, 'role' => $role->id]) }}"
			>
			</datatable>
		</div>
	</div>

@endsection