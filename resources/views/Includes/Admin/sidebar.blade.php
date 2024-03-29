<div class="left-side-menu">
    <div class="media user-profile mt-2 mb-2">
        <img src="{{URL::to('storage/app/public/Adminassets/images/users/avatar-7.jpg')}}"
             class="avatar-sm rounded-circle mr-2" alt="Shreyu"/>
        <img src="{{URL::to('storage/app/public/Adminassets/images/users/avatar-7.jpg')}}"
             class="avatar-xs rounded-circle mr-2" alt="Shreyu"/>

        <div class="media-body">
            <h6 class="pro-user-name mt-0 mb-0">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h6>
            <span class="pro-user-desc">Administrator</span>
        </div>
        <div class="dropdown align-self-center profile-dropdown-menu">
            <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
               aria-expanded="false">
                <span data-feather="chevron-down"></span>
            </a>
            <div class="dropdown-menu profile-dropdown">
{{--                <a href="pages-profile.html" class="dropdown-item notify-item">--}}
{{--                    <i data-feather="user" class="icon-dual icon-xs mr-2"></i>--}}
{{--                    <span>My Account</span>--}}
{{--                </a>--}}

{{--                <a href="javascript:void(0);" class="dropdown-item notify-item">--}}
{{--                    <i data-feather="settings" class="icon-dual icon-xs mr-2"></i>--}}
{{--                    <span>Settings</span>--}}
{{--                </a>--}}

{{--                <div class="dropdown-divider"></div>--}}

                <a href="{{URL::to('master-admin/logout')}}" class="dropdown-item notify-item">
                    <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>
    <div class="sidebar-content">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="slimscroll-menu">
            <ul class="metismenu" id="menu-bar">
                <li class="menu-title">Navigation</li>

                <li>
                    <a href="{{URL::to('master-admin')}}">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
{{--                <li>--}}
{{--                    <a href="{{URL::to('master-admin/calendar')}}">--}}
{{--                        <i data-feather="calendar"></i>--}}
{{--                        <span> Calendar </span>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="menu-title">Apps</li>
                <li>
                    <a href="javascript: void(0);">
                        <i data-feather="users"></i>
                        <span>  Administrator </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{URL::to('master-admin/admin')}}">Super Admin</a>
                        </li>
                        <li>
                            <a href="{{URL::to('master-admin/admin')}}">Administrator</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);">
                        <i data-feather="users"></i>
                        <span> Benutzer </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{URL::to('master-admin/users')}}">Customer</a>
                        </li>
                        <li>
                            <a href="{{URL::to('master-admin/service-provider')}}">Dienstleister</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);">
                        <i data-feather="users"></i>
                        <span> Category </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{URL::to('master-admin/category')}}">Gastronomy</a>
                        </li>
                        <li>
                            <a href="{{URL::to('master-admin/cosmetics-category')}}">Kosmetik</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{URL::to('master-admin/store-profile')}}">
                        <i data-feather="airplay"></i>
                        <span>  Betriebsprofil </span>
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('master-admin/features')}}">
                        <i data-feather="award"></i>
                        <span>Eigenschaften</span>
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('master-admin/plans')}}">
                        <i data-feather="award"></i>
                        <span> Pakete </span>
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('master-admin/payment-info')}}">
                        <i data-feather="credit-card"></i>
                        <span>Zahlungsübersicht </span>
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('master-admin/appointment-list')}}">
                        <i data-feather="shield"></i>
                        <span> Terminübersicht</span>
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('master-admin/become-partner')}}">
                        <i data-feather="clipboard"></i>
                        <span> Dienstleisteranfragen </span>
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('master-admin/contract-list')}}">
                        <i data-feather="clipboard"></i>
                        <span> Contract List </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
