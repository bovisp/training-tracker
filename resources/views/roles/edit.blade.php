@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<h2 class="title is-2">Edit role</h2>
			
			<form action="/roles/{{ $role->id }}" method="POST">
				{{ csrf_field() }}

				{{ method_field('put') }}

				<div class="field">
					<label class="label" for="type">Type</label>

					<div class="control">
						<input 
							class="input {{ $errors->any() && $errors->has('type') ? 'is-danger' : '' }}" 
							type="text" 
							id="type" 
							name="type"
							value="{{ empty($errors->any()) ? $role->type : old('type') }}"
						>
					</div>

					@if ($errors->any() && $errors->has('type'))

						<p class="help is-danger">{{ ($errors->get('type'))[0] }}</p>

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
							value="{{ empty($errors->any()) ? $role->getTranslation('name', 'en') : old('name_en') }}"
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
							value="{{ empty($errors->any()) ? $role->getTranslation('name', 'fr') : old('name_fr') }}"
						>
					</div>

					@if ($errors->any() && $errors->has('name_fr'))

						<p class="help is-danger">{{ ($errors->get('name_fr'))[0] }}</p>

					@endif
				</div>

				<div class="field">
					<div class="control">
						<button class="button is-link">Edit role</button>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection