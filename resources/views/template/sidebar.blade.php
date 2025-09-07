<nav id="sidebar" class="sidebar js-sidebar">

    <div class="sidebar-content js-simplebar">

        <a class="sidebar-brand" href="{{ route('dashboard.index') }}">
            <img src="/adminkit-main/static/img/icons/logo.png" />
            <span class="align-middle">{{ ENV('APP_NAME') }}</span>
        </a>

        <ul class="sidebar-nav">

            <li class="sidebar-item @yield('dashboard-active')">
                <a class="sidebar-link" href="{{ route('dashboard.index') }}">
                    <i class="bi bi-speedometer2 align-middle"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Data-set
            </li>

            @if (Auth()->user()->role->akses_daftar_profitloss)
                <li class="sidebar-item @yield('profitlosses-active')">
                    <a class="sidebar-link" href="{{ route('profitlosses.index') }}">
                        <i class="bi bi-bar-chart-line-fill align-middle"></i>
                        <span class="align-middle">Profit & Loss</span>
                    </a>
                </li>
            @endif


            <li class="sidebar-header">
                Transaksi
            </li>

            @if (Auth()->user()->role->akses_daftar_invoice)
                <li class="sidebar-item @yield('invoices-active')">
                    <a class="sidebar-link" href="{{ route('invoices.index') }}">
                        <i class="bi bi-receipt align-middle"></i>
                        <span class="align-middle">Invoice</span>
                    </a>
                </li>
            @endif

            @if (Auth()->user()->role->akses_daftar_ticket)
                <li class="sidebar-item @yield('tickets-active')">
                    <a class="sidebar-link" href="{{ route('tickets.index') }}">
                        <i class="bi bi-ticket-detailed align-middle"></i>
                        <span class="align-middle">Ticket</span>
                    </a>
                </li>
            @endif

            <li class="sidebar-header">
                Master
            </li>

            @if (Auth()->user()->role->akses_daftar_jabatan)
                <li class="sidebar-item @yield('roles-active')">
                    <a class="sidebar-link" href="{{ route('roles.index') }}">
                        <i class="bi bi-person-badge align-middle"></i>
                        <span class="align-middle">Jabatan</span>
                    </a>
                </li>
            @endif

            @if (Auth()->user()->role->akses_daftar_user)
                <li class="sidebar-item @yield('users-active')">
                    <a class="sidebar-link" href="{{ route('users.index') }}">
                        <i class="bi bi-people align-middle"></i>
                        <span class="align-middle">User</span>
                    </a>
                </li>
            @endif

            @if (Auth()->user()->role->akses_daftar_produk)
                <li class="sidebar-item @yield('products-active')">
                    <a class="sidebar-link" href="{{ route('products.index') }}">
                        <i class="bi bi-collection align-middle"></i>
                        <span class="align-middle">Produk</span>
                    </a>
                </li>
            @endif

        </ul>


    </div>

</nav>
