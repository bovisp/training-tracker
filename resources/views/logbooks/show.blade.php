@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-desktop">
			<div class="level">
				<div class="level-left">
					<div class="level-item">
						<h2 class="title is-2">Logbook</h2>
					</div>
				</div>

				<div class="level-right">
					<div class="level-item">
						<a href="{{ env('APP_URL') }}/users/{{ $user->id }}/userlessons/{{ $logbook->userlesson_id }}">Back to lesson package</a>
					</div>
				</div>
			</div>

			<p>
				<strong>Level: </strong>
				{{ 
					$logbook->objective->lesson->level->name
				}}
			</p>

			<p>
				<strong>Lesson: </strong>
				{{ 
					number_format($logbook->objective->lesson->number) . ' - ' . $logbook->objective->lesson->name 
				}}
			</p>

			<p class="mb-8">
				<strong>Objective:</strong>
				{{
					$logbook->objective->number . ' - ' .
					$logbook->objective->name
				}}
			</p>

			<logbook 
				endpoint="{{ env('APP_URL') }}/users/{{ $user->id }}/logbooks/{{ $logbook->id }}"
				logbook-id="{{ $logbook->id }}"
				user-id="{{ $logbook->userlesson->user->id }}"
			/>
		</div>
	</div>

@endsection