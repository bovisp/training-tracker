@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<h2 class="title is-2">Add Lesson</h2>
			
			<form action="{{ env('APP_URL') }}/lessons/{{ $lesson->id }}" method="POST">
				{{ csrf_field() }}

				{{ method_field('put') }}

				<div class="field">
					<label class="label" for="level_id">Level</label>

					<div class="control">
						<div class="select {{ $errors->any() && $errors->has('level_id') ? 'is-danger' : '' }}">
							<select 
								name="level_id" 
								id="level_id" 
							>
								<option value="">Select a level...</option>

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
					<label class="label" for="number">Lesson number</label>

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
					<label class="label" for="name_en">Name (English)</label>

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
					<label class="label" for="name_fr">Name (French)</label>

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
					<label class="label" for="depricated">Depricated</label>

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
						<strong>Period(s) in which this training should be covered:</strong>
					</p>

					<label class="checkbox is-block mt-2">
						<input 
							type="checkbox" 
							name="p9" 
							value="1" 
							{{ old('p9') || $lesson->p9 === 1 ? 'checked' : '' }}
						>
						Early EG-03 (0-9 months)
					</label>

					<label class="checkbox is-block mt-2">
						<input 
							type="checkbox" 
							name="p18" 
							value="1" 
							{{ old('p18') || $lesson->p18 === 1 ? 'checked' : '' }}
						>
						Late EG-03 (9-18 months)
					</label>

					<label class="checkbox is-block mt-2">
						<input 
							type="checkbox" 
							name="p30" 
							value="1" 
							{{ old('p30') || $lesson->p30 === 1 ? 'checked' : '' }}
						>
						Early EG-04 (18-30 months)
					</label>

					<label class="checkbox is-block mt-2">
						<input 
							type="checkbox" 
							name="p42" 
							value="1" 
							{{ old('p42') || $lesson->p42 === 1 ? 'checked' : '' }}
						>
						Late EG-04 (30-42 months)
					</label>
				</div>

				<div class="field mt-6">
					<div class="control">
						<button class="button is-link">Update lesson</button>
					</div>
				</div>
			</form>

			<div class="divider divider--relaxed"></div>

			<b-collapse :open="false" v-cloak>
	            <button class="button is-text has-text-danger" slot="trigger">Delete lesson</button>

	            <article class="message is-danger mt-4">
					<div class="message-body">
						<p>
							Are you sure you want to do this? All data associated
							with this lesson (objectives, user lesson plans etc.)
							will be permanently deleted. <strong>Only do this if you are
							absolutely sure this is what you want.</strong>
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
												Delete this lesson
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