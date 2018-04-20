@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<div class="level">
				<div class="level-left">
					<h2 class="title is-2">Roles</h2>
				</div>

				<div class="level-right">
					<a href="/roles/create" class="button is-text">Add role</a>
				</div>
			</div>

			<datatable 
				endpoint="{{ route('roles.index.api') }}"
				:edit-button="true"
				edit-button-endpoint="/roles/"
			>
			</datatable>
		</div>
	</div>

@endsection