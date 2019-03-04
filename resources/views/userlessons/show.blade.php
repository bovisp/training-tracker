@extends('layouts.app')

@section('content')

	<div class="columns is-centered mb-16">
		<div class="column">
			<p>
				<strong>{{ trans('app.pages.userlessons.show.level') }}</strong>	{{ $userlesson->lesson->level->name }}
			</p>

			<p>
				<strong>{{ trans('app.pages.userlessons.show.lessonpackage') }}</strong>

				{{ number_format($userlesson->lesson->number, 2) }} - {{ $userlesson->lesson->name }}
			</p>

			<p>
				<strong>{{ trans('app.pages.userlessons.show.name') }}</strong>

				<a href="{{ env('APP_URL') }}/users/{{ $user->id }}">
					{{ $user->moodleuser->firstname }} {{ $user->moodleuser->lastname }}
				</a>
			</p>

			<userlesson
				:userlesson-id="{{ $userlesson->id }}"
			></userlesson>

			<div class="divider divider--relaxed"></div>

			@if (moodleauth()->user()->hasRole('administrator'))

				<b-collapse :open="false">
		            <button class="button is-text has-text-danger" slot="trigger">
		            	{{ trans('app.pages.userlessons.buttons.deletepackage') }}
		            </button>

		            <article class="message is-danger mt-4">
						<div class="message-body">
							<p>
								{{ trans('app.pages.userlessons.show.deletemessage1') }}<strong>{{ trans('app.pages.userlessons.show.deletemessage2') }}</strong>
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
													{{ trans('app.pages.userlessons.buttons.deletethispackage') }}
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