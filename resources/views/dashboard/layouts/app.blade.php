<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    @include('dashboard.layouts.partials.styles')

    @stack('styles')
  </head>

  <body>
    @include('dashboard.layouts.partials.top-nav')
    <div class="container-fluid">
      <div class="row">

        <!-- Sidebar -->
        @include('dashboard.layouts.partials.sidebar')

        <!-- Main Content Area -->
        <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4 content">
          @yield('content')
        </main>

      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    @stack('scripts')
  </body>

</html>
