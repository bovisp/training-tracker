<ul>
    <li style="display: {{ app()->getLocale() === 'en' ? 'none' : 'block' }};"><a href="{{ url('lang/en') }}">English</a></li>
    <li style="display: {{ app()->getLocale() === 'fr' ? 'none' : 'block' }};"><a href="{{ url('lang/fr') }}">French</a></li>
</ul>