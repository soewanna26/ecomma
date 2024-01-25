<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            Ecomma<span>UI</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Category</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#uiCategory" role="button" aria-expanded="false"
                    aria-controls="uiCategory">
                    <i class="link-icon" data-feather="bookmark"></i>
                    <span class="link-title">Category</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="uiCategory">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('all.category') }}" class="nav-link"> Category</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all.product') }}" class="nav-link">Product</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all.country') }}" class="nav-link">Country</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item nav-category">Components</li>
            <li class="nav-item">
                <a href="{{ route('all.customer') }}" class="nav-link">
                    <i class="fa fa-user"></i>
                    <span class="link-title">Customer</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="{{ route('all.invoice') }}" class="nav-link">
                    <i class="fa fa-sticky-note-o"></i>
                    <span class="link-title">Invoice</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a href="{{ route('all.order') }}" class="nav-link">
                    <i class="fa fa-bell"></i>
                    <span class="link-title">Order</span>
                </a>
            </li>

            <li class="nav-item nav-category">Role And Permission</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#roleUI" role="button" aria-expanded="false"
                    aria-controls="roleUI">
                    <i class="link-icon" data-feather="anchor"></i>
                    <span class="link-title">Role & Permission</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="roleUI">
                    <ul class="nav sub-menu">
                        <li class="nav-item ">
                            <a href="{{ route('all.permission') }}" class="nav-link">All Permission</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all.roles') }}" class="nav-link">All Roles</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('add.roles.permission') }}" class="nav-link">Add Roles Permission</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all.roles.permission') }}" class="nav-link">All Roles Permission</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#admin" role="button" aria-expanded="false"
                    aria-controls="admin">
                    <i class="link-icon" data-feather="anchor"></i>
                    <span class="link-title">Manage Admin User</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="admin">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('all.admin') }}" class="nav-link">All Admin</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('add.admin') }}" class="nav-link">Add Admin</a>
                        </li>
                    </ul>
                </div>
            </li>
            @if (Auth::user()->can('type.menu'))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button"
                        aria-expanded="false" aria-controls="emails">
                        <i class="link-icon" data-feather="mail"></i>
                        <span class="link-title">Property Type</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="emails">
                        <ul class="nav sub-menu">
                            @if (Auth::user()->can('all.type'))
                                <li class="nav-item">
                                    <a href="{{ route('all.type') }}" class="nav-link">All Type</a>
                                </li>
                            @endif
                            @if (Auth::user()->can('add.type'))
                                <li class="nav-item">
                                    <a href="{{ route('add.type') }}" class="nav-link">Add Type</a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
            @endif
            <li class="nav-item nav-category">Docs</li>
            <li class="nav-item">
                <a href="{{ route('all.about') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">About Us</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('all.contact') }}" class="nav-link">
                    <i class="link-icon" data-feather="phone"></i>
                    <span class="link-title">Content Us</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
