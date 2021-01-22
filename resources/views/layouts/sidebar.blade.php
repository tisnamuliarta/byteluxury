<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner scroll-scrollx_visible">
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('imgs/logo.png') }}"
                     class="navbar-brand-img" alt="...">
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link" href="#navbar-forms" data-toggle="collapse" role="button" aria-expanded=""
                           aria-controls="navbar-forms">
                            <i class="ni ni-single-copy-04 "></i>
                            <span class="nav-link-text">Modules</span>
                        </a>
                        <div class="collapse " id="navbar-forms">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item ">
                                    <a
                                       class="nav-link">Approval</a>
                                </li>
                                <li class="nav-item ">
                                    <a
                                       class="nav-link">Assignment</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="#navbar-forms-settings" data-toggle="collapse" role="button"
                           aria-controls="navbar-forms-settings">
                            <i class="fas fa-cog text-orange"></i>
                            <span class="nav-link-text">Setting</span>
                        </a>
                        <div class="collapse " id="navbar-forms-settings">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item ">
                                    <a
                                       class="nav-link">Change Password</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @if(session('UserID') == 'manager')
                        <li class="nav-item ">
                            <a class="nav-link" href="#navbar-forms-master" data-toggle="collapse" role="button"
                               aria-controls="navbar-forms-settings">
                                <i class="ni ni-settings-gear-65 text-blue"></i>
                                <span class="nav-link-text">Master</span>
                            </a>
                            <div class="collapse " id="navbar-forms-master">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item ">
                                        <a
                                           class="nav-link">Users</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                </ul>
                <!-- Divider -->
                <hr class="my-3">
            </div>
        </div>
    </div>
</nav>
