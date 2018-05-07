@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<h2 class="title is-2">Add Lesson</h2>
			
			<form action="/lessons" method="POST">
				{{ csrf_field() }}

				<div class="field">
					<label class="label" for="topic_id">Topic number</label>

					<div class="control">
						<div class="select {{ $errors->any() && $errors->has('topic_id') ? 'is-danger' : '' }}">
							<select 
								name="topic_id" 
								id="topic_id" 
							>
								<option value="">Select a topic...</option>

								@foreach($topics as $topic)

									<option 
										value="{{ $topic->id }}" 
										{{ $topic->id == old('topic_id') ? 'selected' : '' }}
									>
										{{ $topic->name }}
									</option>

								@endforeach

							</select>
						</div>
					</div>

					@if ($errors->any() && $errors->has('topic_id'))

						<p class="help is-danger">{{ ($errors->get('topic_id'))[0] }}</p>

					@endif

				</div>

				<div class="field">
					<label class="label" for="number">Lesson number</label>

					<div class="control">
						<input 
							class="input {{ $errors->any() && $errors->has('type') ? 'is-danger' : '' }}" 
							type="number" 
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
					<div class="control">
						<button class="button is-link">Add lesson</button>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection