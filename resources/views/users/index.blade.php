@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-desktop">
			<div class="level mb-8">
				<div class="level-left">
					<h2 class="title is-2">{{ trans('app.pages.users.index.title') }}</h2>
				</div>

				<div class="level-right">
					<a href="{{ route('users.create') }}" class="button is-text">{{ trans('app.pages.users.buttons.addusers') }}</a> | 
					<a href="{{ route('inactiveusers.index') }}" class="button is-text">{{ trans('app.pages.users.buttons.inactiveusers') }}</a>
				</div>
			</div>

			<data-table 
				endpoint="{{ route('users.index.api') }}"
			>
			</data-table>
		</div>
	</div>

@endsection