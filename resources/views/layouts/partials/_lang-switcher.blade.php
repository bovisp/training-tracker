<a href="{{ url('lang/en') }}" style="display: {{ app()->getLocale() === 'en' ? 'none' : 'block' }};">
	English
</a>

<a href="{{ url('lang/fr') }}" style="display: {{ app()->getLocale() === 'fr' ? 'none' : 'block' }};">
	French
</a>
