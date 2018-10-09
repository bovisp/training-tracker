@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<h2 class="title is-2">Add Objective</h2>
			
			<form action="/objectives" method="POST">
				{{ csrf_field() }}

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
										{{ $lesson->id == old('lesson_id') ? 'selected' : '' }}
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
							value="{{ old('number') }}"
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
							value="{{ old('name_en') }}"
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
							value="{{ old('name_fr') }}"
						>
					</div>

					@if ($errors->any() && $errors->has('name_fr'))

						<p class="help is-danger">{{ ($errors->get('name_fr'))[0] }}</p>

					@endif
				</div>

				<div class="field">
					<label class="label" for="notebook_required">Logbook required</label>

					<div class="control">
						<div class="select {{ $errors->any() && $errors->has('notebook_required') ? 'is-danger' : '' }}">
							<select 
								name="notebook_required" 
								id="notebook_required" 
							>
								<option 
									value="0" 
									{{ $lesson->notebook_required == 0 ? 'selected' : '' }}
								>No</option>

								<option 
									value="1" 
									{{ $lesson->notebook_required == 1 ? 'selected' : '' }}
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
						<button class="button is-link">Add objective</button>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection