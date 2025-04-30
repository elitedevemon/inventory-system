<nav class="col-md-2 d-none d-md-block sidebar">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">

      <!-- Dashboard -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('dashboard.index') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
          <i class="bi bi-house-door-fill"></i> Dashboard
        </a>
      </li>

      <!-- Categories -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('dashboard.categories.*') ? 'active' : '' }}" href="{{ route('dashboard.categories.index') }}">
          <i class="bi bi-tags-fill"></i> Categories
        </a>
      </li>

      <!-- Products -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('dashboard.products.*') ? 'active' : '' }}" href="{{ route('dashboard.products.index') }}">
          <i class="bi bi-box-seam"></i> Products
        </a>
      </li>

      <!-- Purchases -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('dashboard.purchases.*') ? 'active' : '' }}" href="{{ route('dashboard.purchases.index') }}">
          <i class="bi bi-cart-plus-fill"></i> Purchases
        </a>
      </li>

      <!-- Sales -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('dashboard.sales.*') ? 'active' : '' }}" href="{{ route('dashboard.sales.index') }}">
          <i class="bi bi-currency-dollar"></i> Sales
        </a>
      </li>

      <!-- Suppliers -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('dashboard.suppliers.*') ? 'active' : '' }}" href="{{ route('dashboard.suppliers.index') }}">
          <i class="bi bi-truck"></i> Suppliers
        </a>
      </li>

      <!-- Customers -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('dashboard.customers.*') ? 'active' : '' }}" href="{{ route('dashboard.customers.index') }}">
          <i class="bi bi-people-fill"></i> Customers
        </a>
      </li>

      <!-- Reports (with submenu) -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#reportMenu" role="button" aria-expanded="false" aria-controls="reportMenu">
          <i class="bi bi-graph-up"></i> Reports
        </a>
        <div class="collapse {{ request()->is('dashboard.reports/*') ? 'show' : '' }}" id="reportMenu">
          <ul class="btn-toggle-nav list-unstyled fw-normal small ps-3">
            <li><a class="nav-link {{ Route::is('dashboard.reports.sales') ? 'active' : '' }}" href="{{ route('dashboard.reports.sales') }}">Sales Report</a></li>
            <li><a class="nav-link {{ Route::is('dashboard.reports.purchases') ? 'active' : '' }}" href="{{ route('dashboard.reports.purchases') }}">Purchase Report</a></li>
            <li><a class="nav-link {{ Route::is('dashboard.reports.stock') ? 'active' : '' }}" href="{{ route('dashboard.reports.stock') }}">Stock Report</a></li>
          </ul>
        </div>
      </li>

    </ul>
  </div>
</nav>

