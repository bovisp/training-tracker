@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column">
			<p>
				<strong>Level:</strong>	{{ $userlesson->lesson->level->name }}
			</p>

			<p>
				<strong>Lesson package:</strong>

				{{ $userlesson->lesson->number }} - {{ $userlesson->lesson->name }}
			</p>

			<p>
				<strong>Name:</strong>

				{{ $user->moodleuser->firstname }} {{ $user->moodleuser->lastname }}
			</p>

			<user-lesson 
				:user-lesson="{{ $userlesson }}"
				:user="{{ $user }}"
			></user-lesson>

			<div class="divider divider--relaxed"></div>

			@if (moodleauth()->user()->hasRole('administrator'))

				<b-collapse :open="false">
		            <button class="button is-text has-text-danger" slot="trigger">Delete lesson package</button>

		            <article class="message is-danger mt-4">
						<div class="message-body">
							<p>
								Are you sure you want to do this? All data associated
								with this package (objectives completed, comments, status and logbooks)
								will be permanently deleted. <strong>Only do this if you are
								absolutely sure this is what you want.</strong>
							</p>

							<div class="level">
								<div class="level-left"></div>

								<div class="level-right">
									<form action="{{ env('APP_URL') }}/users/{{ $user->id }}/userlessons/{{ $userlesson->id }}" method="POST">
										{{ csrf_field() }}

										{{ method_field('delete') }}

										<div class="field">
											<div class="control">
												<button class="button is-small is-danger">
													Delete this lesson package
												</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</article>
		        </b-collapse>

			@endif

		</div>
	</div>

@endsection