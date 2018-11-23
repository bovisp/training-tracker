<strong class="mr-2">{{ trans('app.pages.layouts.langswitcher.switchto') }}</strong>

<a href="{{ url('lang/en') }}" style="display: {{ app()->getLocale() === 'en' ? 'none' : 'block' }};">
	{{ trans('app.pages.layouts.langswitcher.english') }}
</a>

<a href="{{ url('lang/fr') }}" style="display: {{ app()->getLocale() === 'fr' ? 'none' : 'block' }};">
	{{ trans('app.pages.layouts.langswitcher.french') }}
</a>
