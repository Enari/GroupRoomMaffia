<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/">Home</a>
      </li>
@auth
      <li class="nav-item">
        <a class="nav-link" href="/bookings">Bookings</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Schedulled bookings</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/sessions">Sessions</a>
      </li>
@endauth
    </ul>
    <ul class="navbar-nav">
@auth
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ \Auth::user()->username }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="/logout">Logout</a>
        </div>
      </li>
@endauth
@guest
      <li class="nav-item">
        <a class="nav-link" href="/login">Login</a>
      </li>
@endguest
    </ul>

  </div>
</nav>
<div class="container-fluid" style="padding-bottom: 1rem"></div> {{-- Ugly hack to get the padding to work... --}}
