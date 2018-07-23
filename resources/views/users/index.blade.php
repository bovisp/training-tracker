@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-desktop">
			<div class="level">
				<div class="level-left">
					<h2 class="title is-2">Users</h2>
				</div>

				<div class="level-right">
					<a href="/users/create" class="button is-text">Add users</a> | 
					<a href="/users/inactive" class="button is-text">Inactive users</a>
				</div>
			</div>

			<data-table 
				endpoint="{{ route('users.index.api') }}"
			>
			</data-table>
		</div>
	</div>

@endsection