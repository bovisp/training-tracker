@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<h2 class="title is-2">{{ trans('app.pages.objectives.create.title') }}</h2>
			
			<form action="{{ env('APP_URL') }}/objectives" method="POST">
				{{ csrf_field() }}

				<div class="field">
					<label class="label" for="lesson_id">{{ trans('app.pages.objectives.fields.lessonnumber') }}</label>

					<div class="control">
						<div class="select {{ $errors->any() && $errors->has('lesson_id') ? 'is-danger' : '' }}">
							<select 
								name="lesson_id" 
								id="lesson_id" 
							>
								<option value="">{{ trans('app.pages.objectives.fields.selectlesson') }}</option>

								@foreach($lessons as $lesson)

									<option 
										value="{{ $lesson->id }}" 
										{{ $lesson->id == old('lesson_id') ? 'selected' : '' }}
									>
										{{ number_format($lesson->number, 2) }} - {{ $lesson->name }}
									</option>

								@endforeach

							</select>
						</div>
					</div>

					@if ($errors->any() && $errors->has('lesson_id'))

						<p class="help is-danger">{{ ($errors->get('lesson_id'))[0] }}</p>

					@endif

				</div>

				<div class="field">
					<label class="label" for="number">{{ trans('app.pages.objectives.fields.objectivenumber') }}</label>

					<div class="control">
						<input 
							class="input {{ $errors->any() && $errors->has('number') ? 'is-danger' : '' }}" 
							type="text" 
							id="number" 
							name="number"
							value="{{ old('number') }}"
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
							value="{{ old('name_en') }}"
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
							value="{{ old('name_fr') }}"
						>
					</div>

					@if ($errors->any() && $errors->has('name_fr'))

						<p class="help is-danger">{{ ($errors->get('name_fr'))[0] }}</p>

					@endif
				</div>

				<div class="field">
					<label class="label" for="notebook_required">{{ trans('app.pages.objectives.fields.logbookrequired') }}</label>

					<div class="control">
						<div class="select {{ $errors->any() && $errors->has('notebook_required') ? 'is-danger' : '' }}">
							<select 
								name="notebook_required" 
								id="notebook_required" 
							>
								<option 
									value="0" 
									{{ $lesson->notebook_required == 0 ? 'selected' : '' }}
								>{{ trans('app.general.no') }}</option>

								<option 
									value="1" 
									{{ $lesson->notebook_required == 1 ? 'selected' : '' }}
								>{{ trans('app.general.yes') }}</option>
							</select>
						</div>
					</div>

					@if ($errors->any() && $errors->has('notebook_required'))

						<p class="help is-danger">{{ ($errors->get('notebook_required'))[0] }}</p>

					@endif

				</div>

				<div class="field">
					<div class="control">
						<button class="button is-link">{{ trans('app.pages.objectives.buttons.addobjective') }}</button>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection