@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<div class="level">
				<div class="level-left">
					<h2 class="title is-2">Lessons</h2>
				</div>

				<div class="level-right">
					<a href="/lessons/create" class="button is-text">Add lesson</a>
				</div>
			</div>

			<datatable 
				endpoint="{{ route('lessons.index.api') }}"
				:custom-headers="['id', 'topic', 'number', 'name', 'depricated']"
				sort-key="topic"
				secondary-sort="number"
				:action-button="true"
				action-button-endpoint="/lessons/"
				action-button-endpoint-suffix="/edit"
				action-button-text="Edit"
			>
			</datatable>
		</div>
	</div>

@endsection