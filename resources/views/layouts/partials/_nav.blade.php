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
        @include('layouts.partials._notifications')

        <b-dropdown position="is-bottom-left" v-cloak>
          <a class="navbar-item" slot="trigger">
            <span>Menu</span>

            <b-icon icon="menu-down"></b-icon>
          </a>

          <b-dropdown-item custom>
            Logged in as <b>{{ moodleauth()->user()->firstname }} {{ moodleauth()->user()->lastname }}</b>
          </b-dropdown-item>

          <hr class="dropdown-divider">

          <b-dropdown-item custom>
            <h6 class="title is-6">Actions:</h6>
          </b-dropdown-item>

          <b-dropdown-item has-link>
            <a href="{{ route('users.index') }}">
              Manage users
            </a>
          </b-dropdown-item>

          <b-dropdown-item has-link>
            <a href="{{ route('roles.index') }}">
              Manage roles
            </a>
          </b-dropdown-item>

          <b-dropdown-item has-link>
            <a href="{{ route('topics.index') }}">
              Manage topics
            </a>
          </b-dropdown-item>

          <b-dropdown-item has-link>
            <a href="{{ route('lessons.index') }}">
              Manage lessons
            </a>
          </b-dropdown-item>

          <b-dropdown-item has-link>
            <a href="{{ route('objectives.index') }}">
              Manage objectives
            </a>
          </b-dropdown-item>

          <hr class="dropdown-divider">

          <b-dropdown-item has-link>
            <a href="{{ route('users.show', [ 'user' => moodleauth()->id() ]) }}">
              <b-icon icon="account"></b-icon>

              Profile
            </a>
          </b-dropdown-item>

          <hr class="dropdown-divider">

          <b-dropdown-item has-link>
            <a href="http://msc-educ-smc.cmc.ec.gc.ca/moodle">
              <b-icon icon="exit-to-app"></b-icon>

              Return to Moodle
            </a>
          </b-dropdown-item> 
        </b-dropdown>
      </div>
    </div>
  </div>
</nav>