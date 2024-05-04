<aside class="sidebar sidebar-base " id="first-tour" data-toggle="main-sidebar" data-sidebar="responsive">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="{{route('admin.dashboard')}}" class="navbar-brand">
            
            <!--Logo start-->
            <div class="logo-main">
                <div class="logo-normal">
                    <div class="icon-30">
                        <img src="{{asset('assets/images/logo-ip.png')}}" alt="" width="200" class="pb-5 d-block mx-auto my-auto">
                    </div>
                </div>
                <div class="logo-mini">
                    <div class="icon-30">
                        <img src="{{asset('assets/images/new-logo.png')}}" alt="">
                    </div>
                </div>
            </div>
            <!--logo End-->            
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg class="icon-20" width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <!-- Sidebar Menu Start -->
            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
            
                <li class="nav-item static-item">
                    <a class="nav-link static-item disabled text-start" href="#" tabindex="-1">
                        <span class="default-icon">Home</span>
                        <span class="mini-icon" data-bs-toggle="tooltip" title="Home" data-bs-placement="right">-</span>
                    </a>
                </li>
            
                <li class="nav-item">
                    <a class="nav-link {{request()->segment(1) == 'admin' && request()->segment(2) == null ? 'active' : ''}}" aria-current="page" href="{{route('admin.dashboard')}}">
                        <i class="icon" data-bs-toggle="tooltip" title="Dashboard" data-bs-placement="right">
                            <svg width="20" class="icon-20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4" d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z" fill="currentColor"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="currentColor"></path>
                            </svg>
                        </i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                <li>
                    <hr class="hr-horizontal">
                </li>
                <li class="nav-item static-item">
                    <a class="nav-link static-item disabled text-start" href="#" tabindex="-1">
                        <span class="default-icon">Menu {{Auth::user()->role->name ?? ''}}</span>
                        <span class="mini-icon" data-bs-toggle="tooltip" title="Home" data-bs-placement="right">-</span>
                    </a>
                </li>
                @include('admin.partials.navbar.administrasi')
                @include('admin.partials.navbar.inisialisasi-data')
                @include('admin.partials.navbar.kontrak')
                @include('admin.partials.navbar.data-master')
                @include('admin.partials.navbar.inputan')
                @include('admin.partials.navbar.laporan')
                @include('admin.partials.navbar.analisa')
                @include('admin.partials.navbar.batu-bara')
                @include('admin.partials.navbar.bbm')
                @include('admin.partials.navbar.kapal')
                @include('admin.partials.navbar.stock-opname')
                @include('admin.partials.navbar.tug')
                @include('admin.partials.navbar.pencatatan-counter')
                @include('admin.partials.navbar.perbaikan-data-bongkar')
                @include('admin.partials.navbar.setting')
            </ul>
            
            <!-- Sidebar Menu End -->        
        </div>
    </div>
    <div class="sidebar-footer"></div>
</aside> 