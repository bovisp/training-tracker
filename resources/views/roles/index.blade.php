@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<div class="level">
				<div class="level-left">
					<h2 class="title is-2">{{ trans('app.pages.roles.index.title') }}</h2>
				</div>

				<div class="level-right">
					<a href="{{ env('APP_URL') }}/roles/create" class="button is-text">{{ trans('app.pages.roles.buttons.addrole') }}</a>
				</div>
			</div>

			<data-table 
				endpoint="{{ route('roles.index.api') }}"
			>
			</data-table>
		</div>
	</div>

@endsection