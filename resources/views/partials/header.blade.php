<header class="site-header">
  <div class="container">
    <h1 class="school-logo-text float-left">
      <a href="{{ home_url('/') }}"><strong>Fictional</strong> University</a>
    </h1>
    <a href="{{ esc_url( site_url('/search') ) }}" class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
    <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
    <div class="site-header__menu group">
      <nav class="main-navigation">
        {{ wp_nav_menu( [
          'theme_location'  => 'primary_navigation',
          'menu'            => null,
          'container'       => null,
          'menu_class'      => '',
        ] ) }}
       {{--  <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Programs</a></li>
          <li><a href="#">Events</a></li>
          <li><a href="#">Campuses</a></li>
          <li><a href="#">Blog</a></li>
        </ul> --}}
      </nav>
      <div class="site-header__util">

        @if ( is_user_logged_in() )

          <a href="{{ esc_url( site_url('/my-notes') ) }}" class="btn btn--small btn--orange float-left push-right">My notes</a>

          <a href="{{ wp_logout_url() }}" class="btn btn--small btn--dark-orange btn--with-photo float-left ">
            <span class="site-header__avatar">{!! get_avatar( get_current_user_id(), 60 ) !!}</span>
            <span class="btn__text">Logout</span>
          </a>

        @else

          <a href="{{ wp_login_url() }}" class="btn btn--small btn--orange float-left push-right">Login</a>
          <a href="{{ wp_registration_url() }}`" class="btn btn--small btn--dark-orange float-left">Sign Up</a>

        @endif

        <a href="{{ esc_url( site_url('/search') ) }}" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>
</header>
