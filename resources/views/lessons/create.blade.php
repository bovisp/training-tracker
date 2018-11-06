@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<h2 class="title is-2">Add Lesson</h2>
			
			<form action="{{ env('APP_URL') }}/lessons" method="POST">
				{{ csrf_field() }}

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
										{{ $level->id == old('level_id') ? 'selected' : '' }}
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
					<p>
						<strong>Period(s) in which this training should be iniated:</strong>
					</p>

					<label class="checkbox is-block mt-2">
						<input 
							type="checkbox" 
							name="p9" 
							value="1" 
							{{ old('p9') ? 'checked' : '' }}
						>
						Early EG-03 (0-9 months)
					</label>

					<label class="checkbox is-block mt-2">
						<input 
							type="checkbox" 
							name="p18" 
							value="1"
							{{ old('p18') ? 'checked' : '' }}
						>
						Late EG-03 (9-18 months)
					</label>

					<label class="checkbox is-block mt-2">
						<input 
							type="checkbox" 
							name="p30" 
							value="1"
							{{ old('p30') ? 'checked' : '' }}
						>
						Early EG-04 (18-30 months)
					</label>

					<label class="checkbox is-block mt-2">
						<input 
							type="checkbox" 
							name="p42" 
							value="1"
							{{ old('p42') ? 'checked' : '' }}
						>
						Late EG-04 (30-42 months)
					</label>

					@if ($errors->any() && $errors->has('p9'))

						<p class="help is-danger">{{ ($errors->get('p9'))[0] }}</p>

					@endif

					@if ($errors->any() && $errors->has('p18'))

						<p class="help is-danger">{{ ($errors->get('p18'))[0] }}</p>

					@endif

					@if ($errors->any() && $errors->has('p30'))

						<p class="help is-danger">{{ ($errors->get('p30'))[0] }}</p>

					@endif

					@if ($errors->any() && $errors->has('p42'))

						<p class="help is-danger">{{ ($errors->get('p42'))[0] }}</p>

					@endif
				</div>

				<div class="field">
					<div class="control">
						<button class="button is-link">Add lesson</button>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection