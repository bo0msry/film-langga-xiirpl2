<div class="header">
  <div class="container">
    <div class="w3layouts_logo">
      <a href="{{ route('home') }}"><h1>One<span>Movies</span></h1></a>
    </div>
    <div class="w3_search">
      <form action="#" method="post">
        <input type="text" name="Search" placeholder="Search" required="">
        <input type="submit" value="Go">
      </form>
    </div>
    <div class="w3l_sign_in_register">
      <ul>
        @auth
          <li><a href="{{ route('admin.films.index') }}">Dashboard Admin</a></li>
          <li>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
              @csrf
              <button type="submit" style="background:none;border:none;color:#ff8d1b;font-size:1em;padding:0;">Logout</button>
            </form>
          </li>
        @else
          <li><a href="#" data-toggle="modal" data-target="#myModal">Login / Register</a></li>
        @endauth
      </ul>
    </div>
    <div class="clearfix"> </div>
  </div>
</div>
