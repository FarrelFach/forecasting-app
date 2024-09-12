<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/home" class="nav-link">Home</a>
      </li>
      </ul>
      <ul class="navbar-nav ml-auto">
      <li class="nav-item">
          <a class="nav-link" href="{{ url('profile') }}">
            <i class="fas fa-user"></i> Profile
          </a>
        </li>

        <!-- Logout Link -->
        <li class="nav-item">
        <a class="nav-link " href="{{ route('logout') }}" role="button"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>{{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
          </a>
        </li>
    </ul>
  </nav>