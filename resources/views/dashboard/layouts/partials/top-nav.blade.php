<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Inventory System</a>
    <div class="d-flex ms-auto">
      <span class="me-3 text-white">Welcome, {{ Auth::user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-outline-light btn-sm" type="submit">Logout</button>
      </form>
    </div>
  </div>
</nav>