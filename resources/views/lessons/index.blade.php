@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet">
			<div class="level">
				<div class="level-left">
					<h2 class="title is-2">{{ trans('app.pages.lessons.index.title') }}</h2>
				</div>

				<div class="level-right">
					<a href="{{ env('APP_URL') }}/lessons/create" class="button is-text">
						{{ trans('app.pages.lessons.buttons.addlesson') }}
					</a>
				</div>
			</div>

			<data-table 
				endpoint="{{ route('lessons.index.api') }}"
			>
			</data-table>
		</div>
	</div>

@endsection