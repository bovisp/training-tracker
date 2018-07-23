@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-desktop">
			<div class="level">
				<div class="level-left">
					<h2 class="title is-2">Objectives</h2>
				</div>

				<div class="level-right">
					<a href="/objectives/create" class="button is-text">Add objective</a>
				</div>
			</div>

			<data-table 
				endpoint="{{ route('objectives.index.api') }}"
			>
			</data-table>
		</div>
	</div>

@endsection