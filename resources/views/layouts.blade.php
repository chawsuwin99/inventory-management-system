<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory Management System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #1e293b;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding: 25px 15px;
        }

        .sidebar h4 {
            font-weight: bold;
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2563eb;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .topbar {
            background: white;
            padding: 18px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        }

        .content-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h4>📦 Inventory Pro</h4>

    {{-- Dashboard: Admin & Staff --}}
    <a href="{{ route('dashboard') }}"
       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        Dashboard
    </a>

    {{-- Admin Only --}}
    @if(Auth::user()->isAdmin())

        <a href="{{ route('categories.index') }}"
           class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
            Categories
        </a>

    @endif

    {{-- Admin & Staff --}}
    <a href="{{ route('products.index') }}"
       class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
        Products
    </a>

    {{-- Admin Only --}}
    @if(Auth::user()->isAdmin())

        <a href="{{ route('suppliers.index') }}"
           class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            Suppliers
        </a>

    @endif

    {{-- Admin & Staff --}}
    <a href="{{ route('stock-transactions.index') }}"
       class="{{ request()->routeIs('stock-transactions.*') ? 'active' : '' }}">
        Stock Transactions
    </a>

    {{-- Admin Only --}}
    @if(Auth::user()->isAdmin())

        <a href="{{ route('reports.index') }}"
           class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
            Reports
        </a>

    @endif
</div>


    <div class="main-content">

       <div class="topbar d-flex justify-content-between align-items-center">
    <h5 class="mb-0">@yield('page-title', 'Inventory Management')</h5>

    <div class="d-flex align-items-center gap-3">
        <span class="fw-semibold text-secondary">
            <i class="bi bi-person-circle"></i>
            {{ Auth::user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </button>
        </form>
    </div>
</div>

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>