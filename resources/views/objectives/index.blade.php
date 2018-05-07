@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-desktop">
			<div class="level">
				<div class="level-left">
					<h2 class="title is-2">Objectives</h2>
				</div>

				<div class="level-right">
					<a href="/objective/create" class="button is-text">Add objective</a>
				</div>
			</div>

			<datatable 
				endpoint="{{ route('objectives.index.api') }}"
				:custom-headers="['id', 'topic', 'lesson', 'number', 'name']"
				sort-key="topic"
				secondary-sort="lesson"
				tertiary-sort="number"
				:action-button="true"
				action-button-endpoint="/objectives/"
				action-button-endpoint-suffix="/edit"
				action-button-text="Edit"
			>
			</datatable>
		</div>
	</div>

@endsection