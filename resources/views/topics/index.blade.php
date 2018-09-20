@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<div class="level">
				<div class="level-left">
					<h2 class="title is-2">Topics</h2>
				</div>

				<div class="level-right">
					<a href="/topics/create" class="button is-text">Add topic</a>
				</div>
			</div>

			{{-- <datatable 
				endpoint="{{ route('topics.index.api') }}"
				:sort="{key: 'number', order: 'asc'}"
				:action-button="true"
				action-button-endpoint="/topics/"
				action-button-endpoint-suffix="/edit"
				action-button-text="Edit"
			>
			</datatable> --}}

			<data-table 
				endpoint="{{ route('topics.index.api') }}"
			>
			</data-table>
		</div>
	</div>

@endsection