<nav class="navbar is-transparent">
  <div class="navbar-brand">
  </div>
  <div class="navbar-start">
    @auth
    @if(hasPermission('home'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button is-info" href="{{route('home')}}">
            <span>Home</span>
          </a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('applications.create'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button is-primary" href="{{route('applications.create')}}">
            <span>New Application</span>
          </a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('applications.pending'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button is-primary" href="{{route('applications.pending')}}">
            <span>Pending Applications</span>
          </a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('businesses.expiringsoon'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button is-primary" href="{{route('businesses.expiringsoon')}}">
            <span>Expiring Soon</span>
          </a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('applications.index'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button is-primary" href="{{route('applications.index')}}">
            <span>Inspection Applications</span>
          </a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('inspections.upcoming'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button is-primary" href="{{route('inspections.upcoming')}}">
            <span>Upcoming Inspections</span>
          </a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('grading-inspections.upcoming'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button is-primary" href="{{route('grading-inspections.upcoming')}}">
            <span>Upcoming Grading Inspections</span>
          </a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('manage'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button is-primary" href="{{route('manage')}}">
            <span>Manage</span>
          </a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('tasks'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button is-primary" href="{{route('tasks')}}">
            <span>Tasks</span>
          </a>
        </p>
      </div>
    </div>
    @endif
    @endauth
  </div>
   

  <div class="navbar-end">
    @guest
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button is-primary" href="{{ route('login') }}">
            <span>Login</span>
          </a>
        </p>
      </div>
    </div>
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button is-primary" href="{{ route('register') }}">
            <span>Register</span>
          </a>
        </p>
      </div>
    </div>
    @else
    <div class="navbar-item">
      <div class="field is-grouped">
        <!-- <p class="control"> -->
          <!-- <a class="button is-primary" href="#"> -->
            <span>{{ Auth::user()->name }}</span>
          <!-- </a> -->
        <!-- </p> -->
      </div>
    </div>
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button is-primary"class="dropdown-item" href="{{ route('logout') }}"
                                     onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
            <span>{{ __('Logout') }}</span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </p>
      </div>
    </div>
    @endguest
  </div>
</nav>