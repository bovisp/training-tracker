@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-desktop">
			<div class="level">
				<div class="level-left">
					<h2 class="title is-2">Add users</h2>
				</div>
			</div>

			

			<user-errors></user-errors>

			<datatable 
				endpoint="{{ route('users.create.api') }}"
				post-endpoint="{{ route('users.store.api') }}"
				redirect-endpoint="{{ route('users.index') }}"
				:custom-headers="['id', 'firstname', 'lastname', 'email']"
				:has-checkbox="true"
				:with-roles="true"
				roles-endpoint="{{ route('roles.index.api') }}"
				success-message="Users successfully added."
			>
			</datatable>
		</div>
	</div>

@endsection