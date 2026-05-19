<aside class="sidebar" id="sidebar">
    <div id="menu-toggle" class="menu-toggle">
    <i class="fa-solid fa-bars"></i>
</div>

    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('dashboard') }}" 
               class="sidebar-item {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-house text-xl"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('transactions') }}" 
               class="sidebar-item {{ request()->routeIs('transactions') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-dollar-sign text-xl"></i>
                <span class="sidebar-text">Transactions</span>
            </a>
        </li>
        <li>
            <a href="#" 
               class="sidebar-item {{ request()->routeIs('statistics') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-chart-bar text-xl"></i>
                <span class="sidebar-text">Statistics</span>
            </a>
        </li>
        <li>
            <a href="{{ route('insights') }}" 
               class="sidebar-item {{ request()->routeIs('insights') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-wallet text-xl"></i>
                <span class="sidebar-text">Insights</span>
            </a>
        </li>
        <li>
            <a href="#" 
               class="sidebar-item {{ request()->routeIs('budget') ? 'sidebar-active' : '' }}">
                <i class="fa-solid fa-bullseye text-xl"></i>
                <span class="sidebar-text">Budget</span>
            </a>
        </li>
    </ul>
</aside>