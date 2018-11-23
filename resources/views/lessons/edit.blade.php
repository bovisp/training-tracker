@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<h2 class="title is-2">{{ trans('app.pages.lessons.edit.title') }}</h2>
			
			<form action="{{ env('APP_URL') }}/lessons/{{ $lesson->id }}" method="POST">
				{{ csrf_field() }}

				{{ method_field('put') }}

				<div class="field">
					<label class="label" for="level_id">{{ trans('app.pages.lessons.fields.level') }}</label>

					<div class="control">
						<div class="select {{ $errors->any() && $errors->has('level_id') ? 'is-danger' : '' }}">
							<select 
								name="level_id" 
								id="level_id" 
							>
								<option value="">{{ trans('app.pages.lessons.fields.selectlevel') }}</option>

								@foreach($levels as $level)

									<option 
										value="{{ $level->id }}"
										{{ $level->id == old('level_id') || $level->id == $lesson->level_id ? 'selected' : '' }}
									>
										{{ $level->name }}
									</option>

								@endforeach

							</select>
						</div>
					</div>

					@if ($errors->any() && $errors->has('level_id'))

						<p class="help is-danger">{{ ($errors->get('level_id'))[0] }}</p>

					@endif

				</div>

				<div class="field">
					<label class="label" for="number">{{ trans('app.pages.lessons.fields.number') }}</label>

					<div class="control">
						<input 
							class="input {{ $errors->any() && $errors->has('number') ? 'is-danger' : '' }}" 
							type="text" 
							id="number" 
							name="number"
							value="{{ empty($errors->any()) ? $lesson->number : old('number') }}"
						>
					</div>

					@if ($errors->any() && $errors->has('number'))

						<p class="help is-danger">{{ ($errors->get('number'))[0] }}</p>

					@endif
				</div>

				<div class="field">
					<label class="label" for="name_en">{{ trans('app.general.fields.nameen') }}</label>

					<div class="control">
						<input 
							class="input {{ $errors->any() && $errors->has('name_en') ? 'is-danger' : '' }}" 
							type="text" 
							id="name_en" 
							name="name_en"
							value="{{ empty($errors->any()) ? $lesson->getTranslation('name', 'en') : old('name_en') }}"
						>
					</div>
					
					@if ($errors->any() && $errors->has('name_en'))

						<p class="help is-danger">{{ ($errors->get('name_en'))[0] }}</p>

					@endif

				</div>

				<div class="field">
					<label class="label" for="name_fr">{{ trans('app.general.fields.namefr') }}</label>

					<div class="control">
						<input 
							class="input  {{ $errors->any() && $errors->has('name_fr') ? 'is-danger' : '' }}" 
							type="text" 
							id="name_fr" 
							name="name_fr"
							value="{{ empty($errors->any()) ? $lesson->getTranslation('name', 'fr') : old('name_fr') }}"
						>
					</div>

					@if ($errors->any() && $errors->has('name_fr'))

						<p class="help is-danger">{{ ($errors->get('name_fr'))[0] }}</p>

					@endif
				</div>

				<div class="field">
					<label class="label" for="depricated">{{ trans('app.pages.lessons.fields.depricated') }}</label>

					<div class="control">
						<div class="select {{ $errors->any() && $errors->has('depricated') ? 'is-danger' : '' }}">
							<select 
								name="depricated" 
								id="depricated" 
							>
								<option 
									value="0"
									{{ old('depricated') == 0 || $lesson->depricated == 0 ? 'selected' : '' }}
								>No</option>

								<option 
									value="1"
									{{ old('depricated') == 1 || $lesson->depricated == 1 ? 'selected' : '' }}
								>Yes</option>

							</select>
						</div>
					</div>

					@if ($errors->any() && $errors->has('depricated'))

						<p class="help is-danger">{{ ($errors->get('depricated'))[0] }}</p>

					@endif

				</div>

				<div class="field">
					<p>
						<strong>{{ trans('app.pages.lessons.fields.periodscovered') }}</strong>
					</p>

					<label class="checkbox is-block mt-2">
						<input 
							type="checkbox" 
							name="p9" 
							value="1" 
							{{ old('p9') || $lesson->p9 === 1 ? 'checked' : '' }}
						>
						{{ trans('app.pages.lessons.fields.period9') }}
					</label>

					<label class="checkbox is-block mt-2">
						<input 
							type="checkbox" 
							name="p18" 
							value="1" 
							{{ old('p18') || $lesson->p18 === 1 ? 'checked' : '' }}
						>
						{{ trans('app.pages.lessons.fields.period18') }}
					</label>

					<label class="checkbox is-block mt-2">
						<input 
							type="checkbox" 
							name="p30" 
							value="1" 
							{{ old('p30') || $lesson->p30 === 1 ? 'checked' : '' }}
						>
						{{ trans('app.pages.lessons.fields.period30') }}
					</label>

					<label class="checkbox is-block mt-2">
						<input 
							type="checkbox" 
							name="p42" 
							value="1" 
							{{ old('p42') || $lesson->p42 === 1 ? 'checked' : '' }}
						>
						{{ trans('app.pages.lessons.fields.period42') }}
					</label>
				</div>

				<div class="field mt-6">
					<div class="control">
						<button class="button is-link">{{ trans('app.pages.lessons.buttons.updatelesson') }}</button>
					</div>
				</div>
			</form>

			<div class="divider divider--relaxed"></div>

			<b-collapse :open="false" v-cloak>
	            <button class="button is-text has-text-danger" slot="trigger">{{ trans('app.pages.lessons.buttons.deletelesson') }}</button>

	            <article class="message is-danger mt-4">
					<div class="message-body">
						<p>
							{{ trans('app.pages.lessons.buttons.deletemessage1') }}<strong>{{ trans('app.pages.lessons.buttons.deletemessage2') }}</strong>
						</p>

						<div class="level">
							<div class="level-left"></div>

							<div class="level-right">
								<form action="{{ env('APP_URL') }}/lessons/{{ $lesson->id }}" method="POST">
									{{ csrf_field() }}

									{{ method_field('delete') }}

									<div class="field">
										<div class="control">
											<button class="button is-small is-danger">
												{{ trans('app.pages.lessons.buttons.deletethislesson') }}
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</article>
	        </b-collapse>
		</div>
	</div>

@endsection