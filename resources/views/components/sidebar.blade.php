<aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
    <div class="p-6">
        <a href="{{ route('dashboard') }}" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>   
    </div>
    <nav class="text-white text-base font-semibold pt-3">
        <a href="{{ route('dashboard') }}" class="flex items-center {{ request()->routeIs('dashboard') ? 'active-nav-link' : '' }} text-white py-4 pl-6 nav-item">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="{{ route('invoices.index') }}" class="flex items-center {{ request()->routeIs('invoices.index') ? 'active-nav-link' : '' }} text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class="fas fa-sticky-note mr-3"></i>
            Invoice
        </a>
        <a href="{{ route('products.index') }}" class="flex items-center {{ request()->routeIs('products.index') ? 'active-nav-link' : '' }} text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class="fas fa-box mr-3"></i>
            Product
        </a>
        <a href="{{ route('customers.index') }}" class="flex items-center {{ request()->routeIs('customers.index') ? 'active-nav-link' : '' }} text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class="fas fa-user mr-3"></i>
            Customer
        </a>
        <a href="{{ route('customers.balance_sheet') }}" class="flex items-center {{ request()->routeIs('customers.balance_sheet') ? 'active-nav-link' : '' }} text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item" >
            <i class="fas fa-balance-scale mr-3"></i>
            Balance Sheet
        </a>
    </nav>
</aside>