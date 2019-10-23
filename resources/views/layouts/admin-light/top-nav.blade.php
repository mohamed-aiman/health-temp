    <nav class="navbar is-white">
        <div class="container is-fluid">
            <div class="navbar-brand">
                <router-link  :to="{ name: 'home' }"    alt="home" >{{ config('app.name', 'Aimme App - +960 9660028') }}</router-link>
                <!-- <a class="navbar-item brand-text" href="/"> -->
                  <!-- {{ config('app.name', 'Aimme App - +960 9660028') }} -->
                <!-- </a> -->
<!--                 <div class="navbar-burger burger" data-target="navMenu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div> -->
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
        </div>
    </nav>