<nav class="navbar is-transparent">
  <div class="navbar-brand">
  </div>
  <div class="navbar-start">
    @if(Auth::check() && hasPermission('home'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button menu-link is-small is-black" href="{{route('home')}}">
            <span>Home</span>
          </a>
        </p>
      </div>
    </div>
    @endif
    @auth
    @if(hasPermission('applications.create'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button menu-link is-small is-info" href="{{route('applications.create')}}" alt="(1)New Application"><span>New Application</span></a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('applications.draft'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button menu-link is-small is-info" href="{{route('applications.draft')}}" alt="(2)Draft Applications"><span>Draft Applications</span></a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('applications.pending'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button menu-link is-small is-primary" href="{{route('applications.pending')}}" alt="(3)Pending Applications"><span>Pending Applications</span></a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('inspections.upcoming'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button menu-link is-small is-primary" href="{{route('inspections.upcoming')}}" alt="(4)Upcoming Inspections"><span>Upcoming Inspections</span></a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('normal-forms.pending'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button menu-link is-small is-secondary" href="{{route('normal-forms.pending')}}" alt="(5)Pending Inspection Forms"><span>Pending Inspection Forms</span></a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('normal-forms.processed'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button menu-link is-small is-primary" href="{{route('normal-forms.processed')}}" alt="(6)Processed Inspection Forms"><span>Processed Inspection Forms</span></a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('inspections.pending-reports'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button menu-link is-small is-secondary" href="{{route('inspections.pending-reports')}}" alt="(7)Forms with Pending Reports"><span>Forms w/Pending Reports</span></a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('inspections.processed-reports'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button menu-link is-small is-primary" href="{{route('inspections.processed-reports')}}" alt="(8)Forms with Processed Reports"><span>Forms w/ Processed Reports</span></a>
        </p>
      </div>
    </div>
    @endif
    @if(hasPermission('manage'))
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button menu-link is-small is-primary" href="{{route('manage')}}">
            <span>Manage</span>
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
          <a class="button menu-link is-small is-primary" href="{{ route('login') }}">
            <span>Login</span>
          </a>
        </p>
      </div>
    </div>
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button menu-link is-small is-primary" href="{{ route('register') }}">
            <span>Register</span>
          </a>
        </p>
      </div>
    </div>
    @else
    <div class="navbar-item">
      <div class="field is-grouped">
        <!-- <p class="control"> -->
          <!-- <a class="button menu-link is-small is-primary" href="#"> -->
            <span>{{ Auth::user()->name }}</span>
          <!-- </a> -->
        <!-- </p> -->
      </div>
    </div>
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="button menu-link is-small is-primary"class="dropdown-item" href="{{ route('logout') }}"
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