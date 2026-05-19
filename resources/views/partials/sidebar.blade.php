<aside class="sidebar">
    <div class="text-2xl mb-12 text-white/60 cursor-pointer hover:text-white transition">
        <i class="fa-solid fa-bars"></i>
    </div>

    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('dashboard') }}" 
               class="sidebar-item {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-house text-xl"></i>
            </a>
        </li>
        <li>
            <a href="{{ route('transactions') }}" 
               class="sidebar-item {{ request()->routeIs('transactions') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-dollar-sign text-xl"></i>
            </a>
        </li>
        <li>
            <a href="#" 
               class="sidebar-item {{ request()->routeIs('reports') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-chart-bar text-xl"></i>
            </a>
        </li>
        <li>
            <a href="#" 
               class="sidebar-item {{ request()->routeIs('budget') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-wallet text-xl"></i>
            </a>
        </li>
        <li>
            <a href="#" 
               class="sidebar-item {{ request()->routeIs('goals') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-bullseye text-xl"></i>
            </a>
        </li>
    </ul>
</aside>