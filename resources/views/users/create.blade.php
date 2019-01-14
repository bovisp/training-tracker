@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-desktop">
			<div class="level">
				<div class="level-left">
					<h2 class="title is-2">{{ trans('app.pages.users.create.title') }}</h2>
				</div>
			</div>			

			<user-errors></user-errors>

			<data-table 
				endpoint="{{ route('users.create.api') }}"
				post-endpoint="{{ route('users.store.api') }}"
				redirect-endpoint="{{ route('users.index') }}"
				:has-checkbox="true"
				:with-roles="true"
				roles-endpoint="{{ route('roles.index.api') }}"
				success-message="{{ trans('app.pages.users.create.usersadded') }}"
			>
			</datatable>
		</div>
	</div>

@endsection