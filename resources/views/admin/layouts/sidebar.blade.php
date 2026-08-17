<aside class="app-sidebar sticky" id="sidebar">

    <div class="main-sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="header-logo">
            <img src="{{ asset('backend/assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('backend/assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('backend/assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('backend/assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('backend/assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
            <img src="{{ asset('backend/assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
        </a>
    </div>
    <div class="main-sidebar" id="sidebar-scroll">

        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> 
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> 
                </svg>
            </div>
            
            <ul class="main-menu">
                
                <li class="slide__category"><span class="category-name">Main</span></li>
                
                <li class="slide">
                    <a href="{{ route('admin.dashboard') }}" class="side-menu__item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="ri-dashboard-3-line side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <li class="slide__category"><span class="category-name">Catalog</span></li>

                <li class="slide">
                    <a href="{{ route('admin.books.index') }}" class="side-menu__item {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                        <i class="ri-book-2-line side-menu__icon"></i>
                        <span class="side-menu__label">Books</span>
                    </a>
                </li>

                <li class="slide">
                    <a href="{{ route('admin.categories.index') }}" class="side-menu__item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="ri-folders-line side-menu__icon"></i>
                        <span class="side-menu__label">Categories</span>
                    </a>
                </li>

                <li class="slide__category"><span class="category-name">People</span></li>

                <li class="slide">
                <a href="{{ route('admin.users.index') }}" class="side-menu__item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="ri-user-settings-line side-menu__icon"></i>
                    <span class="side-menu__label">System Users</span>
                </a>
            </li>

                <li class="slide">
                    <a href="{{ route('admin.students.index') }}" class="side-menu__item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                        <i class="ri-group-line side-menu__icon"></i>
                        <span class="side-menu__label">Students</span>
                    </a>
                </li>

                <li class="slide__category"><span class="category-name">Circulation</span></li>

                <li class="slide">
                    <a href="{{ route('admin.transactions.index') }}" class="side-menu__item {{ request()->routeIs('admin.transactions.index') || request()->routeIs('admin.transactions.show') || request()->routeIs('admin.transactions.create') || request()->routeIs('admin.transactions.edit') ? 'active' : '' }}">
                        <i class="ri-exchange-line side-menu__icon"></i>
                        <span class="side-menu__label">Transactions</span>
                    </a>
                </li>

                <li class="slide">
                    <a href="{{ route('admin.transactions.overdue') }}" class="side-menu__item {{ request()->routeIs('admin.transactions.overdue') ? 'active' : '' }}">
                        <i class="ri-alarm-warning-line side-menu__icon"></i>
                        <span class="side-menu__label">Overdue Books</span>
                    </a>
                </li>

            </ul>
            
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> 
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> 
                </svg>
            </div>
        </nav>
        </div>
    </aside>