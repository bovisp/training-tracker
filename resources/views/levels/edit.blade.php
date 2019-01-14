@extends('layouts.app')

@section('content')

	<div class="columns is-centered">
		<div class="column is-three-quarters-tablet is-half-desktop">
			<h2 class="title is-2">{{ trans('app.pages.levels.edit.title') }}</h2>
			
			<form action="{{ env('APP_URL') }}/levels/{{ $level->id }}" method="POST">
				{{ csrf_field() }}

				{{ method_field('put') }}

				<div class="field">
					<label class="label" for="name_en">{{ trans('app.general.fields.nameen') }}</label>

					<div class="control">
						<input 
							class="input {{ $errors->any() && $errors->has('name_en') ? 'is-danger' : '' }}" 
							type="text" 
							id="name_en" 
							name="name_en"
							value="{{ empty($errors->any()) ? $level->getTranslation('name', 'en') : old('name_en') }}"
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
							value="{{ empty($errors->any()) ? $level->getTranslation('name', 'fr') : old('name_fr') }}"
						>
					</div>

					@if ($errors->any() && $errors->has('name_fr'))

						<p class="help is-danger">{{ ($errors->get('name_fr'))[0] }}</p>

					@endif
				</div>

				<div class="field">
					<div class="control">
						<button class="button is-link">{{ trans('app.pages.levels.buttons.editlevel') }}</button>
					</div>
				</div>
			</form>

			<div class="divider divider--relaxed"></div>

			<b-collapse :open="false" v-cloak>
	            <button class="button is-text has-text-danger" slot="trigger">{{ trans('app.pages.levels.buttons.deletelevel') }}</button>

	            <article class="message is-danger mt-4">
					<div class="message-body">
						<p>
							{{ trans('app.pages.levels.edit.deletemessage1') }} <strong> {{ trans('app.pages.levels.edit.deletemessage2') }} </strong>
						</p>

						<div class="level">
							<div class="level-left"></div>

							<div class="level-right">
								<form action="{{ env('APP_URL') }}/levels/{{ $level->id }}" method="POST">
									{{ csrf_field() }}

									{{ method_field('delete') }}

									<div class="field">
										<div class="control">
											<button class="button is-small is-danger">
												{{ trans('app.pages.levels.buttons.deletethislevel') }}
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