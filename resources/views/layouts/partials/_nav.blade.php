<nav class="navbar has-box-shadow" role="navigation" aria-label="main navigation">
  <div class="container">
    <div class="navbar-brand">
      <a 
        role="button" 
        class="navbar-burger burger" 
        aria-label="menu" 
        aria-expanded="false" 
        data-target="topMenu"
      >
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div id="topMenu" class="navbar-menu">
      <div class="navbar-start">
        <div class="navbar-item">
          @include('layouts.partials._lang-switcher')
        </div>
      </div>

      <div class="navbar-end">
        <div class="navbar-item">

          @if (moodleauth()->user()->hasRole(['head_of_operations', 'supervisor']))

            <unread-notifications 
              :user="{{ moodleauth()->user() }}"
            />

          @endif
        </div>

        <b-dropdown position="is-bottom-left" v-cloak>
          <button class="navbar-item button is-text has-underline-none" slot="trigger">
            <span>{{ trans('app.pages.layouts.nav.menu') }}</span>

            <b-icon icon="menu-down"></b-icon>
          </button>

          <b-dropdown-item custom>
            {{ trans('app.pages.layouts.nav.loggedinas') }}<b>{{ moodleauth()->user()->firstname }} {{ moodleauth()->user()->lastname }}</b>
          </b-dropdown-item>

          @if (moodleauth()->user()->hasRole('administrator'))

            <hr class="dropdown-divider">

            <b-dropdown-item custom>
              <h6 class="title is-6">{{ trans('app.pages.layouts.nav.actions') }}</h6>
            </b-dropdown-item>

            <b-dropdown-item has-link>
              <a href="{{ route('users.index') }}">
                {{ trans('app.pages.layouts.nav.manageusers') }}
              </a>
            </b-dropdown-item>

            <b-dropdown-item has-link>
              <a href="{{ route('roles.index') }}">
                {{ trans('app.pages.layouts.nav.manageroles') }}
              </a>
            </b-dropdown-item>

            <b-dropdown-item has-link>
              <a href="{{ route('levels.index') }}">
               {{ trans('app.pages.layouts.nav.managelevels') }}
              </a>
            </b-dropdown-item>

            <b-dropdown-item has-link>
              <a href="{{ route('lessons.index') }}">
                {{ trans('app.pages.layouts.nav.managelessons') }}
              </a>
            </b-dropdown-item>

            <b-dropdown-item has-link>
              <a href="{{ route('objectives.index') }}">
                {{ trans('app.pages.layouts.nav.manageobjectives') }}
              </a>
            </b-dropdown-item>

          @endif

          <hr class="dropdown-divider">

          <b-dropdown-item has-link>
            <a href="{{ route('users.show', [ 'user' => moodleauth()->id() ]) }}">
              <b-icon icon="account"></b-icon>

              {{ trans('app.pages.layouts.nav.profile') }}
            </a>
          </b-dropdown-item>

          <hr class="dropdown-divider">

          <b-dropdown-item has-link>
            <a href="http://msc-educ-smc.cmc.ec.gc.ca/moodle">
              <b-icon icon="exit-to-app"></b-icon>

              {{ trans('app.pages.layouts.nav.returntomoodle') }}
            </a>
          </b-dropdown-item> 
        </b-dropdown>
      </div>
    </div>
  </div>
</nav>