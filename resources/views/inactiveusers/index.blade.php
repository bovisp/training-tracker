@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-desktop">
			<div class="level">
				<div class="level-left">
					<h2 class="title is-2">{{ trans('app.pages.inactiveusers.title') }}</h2>
				</div>

				<div class="level-right">
					<a href="{{ route('users.index') }}" class="button is-text">
						{{ trans('app.pages.inactiveusers.activeuserslink') }}
					</a>
				</div>
			</div>

			<data-table 
				endpoint="{{ route('inactiveusers.index.api') }}"
			>
			</data-table>
		</div>
	</div>

@endsection