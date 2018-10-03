@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<h2 class="title is-2">Edit Objective</h2>
			
			<form action="/objectives/{{ $objective->id }}" method="POST">
				{{ csrf_field() }}

				{{ method_field('put') }}

				<div class="field">
					<label class="label" for="lesson_id">Lesson number</label>

					<div class="control">
						<div class="select {{ $errors->any() && $errors->has('lesson_id') ? 'is-danger' : '' }}">
							<select 
								name="lesson_id" 
								id="lesson_id" 
							>
								<option value="">Select a lesson...</option>

								@foreach($lessons as $lesson)

									<option 
										value="{{ $lesson->id }}" 
										@if(($lesson->id == old('lesson_id')) || ($lesson->id == $objective->lesson_id)) selected @endif
									> 
										{{ $lesson->topic->number }}.{{ str_pad($lesson->number, 2, '0', STR_PAD_LEFT) }} {{ $lesson->name }}
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
					<label class="label" for="number">Objective number</label>

					<div class="control">
						<input 
							class="input {{ $errors->any() && $errors->has('number') ? 'is-danger' : '' }}" 
							type="text" 
							id="number" 
							name="number"
							value="{{ empty($errors->any()) ? $objective->number : old('number') }}"
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
							value="{{ empty($errors->any()) ? $objective->getTranslation('name', 'en') : old('name_en') }}"
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
							value="{{ empty($errors->any()) ? $objective->getTranslation('name', 'fr') : old('name_fr') }}"
						>
					</div>

					@if ($errors->any() && $errors->has('name_fr'))

						<p class="help is-danger">{{ ($errors->get('name_fr'))[0] }}</p>

					@endif
				</div>

				<div class="field">
					<label class="label" for="notebook_required">Lesson number</label>

					<div class="control">
						<div class="select {{ $errors->any() && $errors->has('notebook_required') ? 'is-danger' : '' }}">
							<select 
								name="notebook_required" 
								id="notebook_required" 
							>
									<option 
										value="0" 
										@if((old('notebook_required') == "0") || ($objective->notebook_required == "0")) selected @endif
									>No</option>

									<option 
										value="1" 
										@if((old('notebook_required') == "1") || ($objective->notebook_required == "1")) selected @endif
									>Yes</option>
							</select>
						</div>
					</div>

					@if ($errors->any() && $errors->has('notebook_required'))

						<p class="help is-danger">{{ ($errors->get('notebook_required'))[0] }}</p>

					@endif

				</div>

				<div class="field">
					<div class="control">
						<button class="button is-link">Edit objective</button>
					</div>
				</div>
			</form>

			<div class="divider divider--relaxed"></div>

			<b-collapse :open="false">
	            <button class="button is-text has-text-danger" slot="trigger">Delete objective</button>

	            <article class="message is-danger mt-4">
					<div class="message-body">
						<p>
							Are you sure you want to do this? All data associated
							with this objective, such as user lesson plans 
							will be permanently deleted. <strong>Only do this if you are
							absolutely sure this is what you want.</strong>
						</p>

						<div class="level">
							<div class="level-left"></div>

							<div class="level-right">
								<form action="/objectives/{{ $objective->id }}" method="POST">
									{{ csrf_field() }}

									{{ method_field('delete') }}

									<div class="field">
										<div class="control">
											<button class="button is-small is-danger">
												Delete this objective
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