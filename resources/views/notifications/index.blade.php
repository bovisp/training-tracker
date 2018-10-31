@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-half-desktop">
			<h2 class="title is-2">
				Notifications for {{ $user->firstname }} {{ $user->lastname }}
			</h2>

			<notifications 
				:user="{{ $user }}"
			></notifications>
		</div>
	</div>

@endsection