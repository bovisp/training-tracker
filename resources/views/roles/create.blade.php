
@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<h2 class="title is-2">{{ trans('app.pages.roles.create.title') }}</h2>
			
			<form action="{{ env('APP_URL') }}/roles" method="POST">
				{{ csrf_field() }}

				<div class="field">
					<label class="label" for="type">{{ trans('app.pages.roles.fields.type') }}</label>

					<div class="control">
						<input 
							class="input {{ $errors->any() && $errors->has('type') ? 'is-danger' : '' }}" 
							type="text" 
							id="type" 
							name="type"
							value="{{ old('type') }}"
						>
					</div>

					@if ($errors->any() && $errors->has('type'))

						<p class="help is-danger">{{ ($errors->get('type'))[0] }}</p>

					@endif
				</div>

				<div class="field">
					<label class="label" for="rank">{{ trans('app.pages.roles.fields.rank') }}</label>

					<div class="control">
						<input 
							class="input {{ $errors->any() && $errors->has('rank') ? 'is-danger' : '' }}" 
							type="number" 
							id="rank" 
							name="rank"
							value="{{ old('rank') }}"
						>
					</div>

					@if ($errors->any() && $errors->has('rank'))

						<p class="help is-danger">{{ ($errors->get('rank'))[0] }}</p>

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
					<div class="control">
						<button class="button is-link">{{ trans('app.pages.roles.buttons.addrole') }}</button>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection