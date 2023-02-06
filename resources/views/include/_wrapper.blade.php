<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <!--begin::Header-->
                    <div id="kt_header" style="" class="header align-items-stretch">
                        <!--begin::Container-->
                        <div class="container-fluid d-flex align-items-stretch justify-content-between">
                            <!--begin::Aside mobile toggle-->
                            <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
                                <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                                    <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                                    <span class="svg-icon svg-icon-2x mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
                                                <path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                            </div>
                            <!--end::Aside mobile toggle-->
                            <!--begin::Mobile logo-->
                            <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                                <a href="../../demo1/dist/index.html" class="d-lg-none">
                                    <img alt="Logo" src="assets/media/logos/chumsy.png" class="h-30px" />
                                </a>
                            </div>
                            <!--end::Mobile logo-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                                <!--begin::Navbar-->
                                <div class="d-flex align-items-stretch" id="kt_header_nav">
                                    <!--begin::Menu wrapper-->
                                    <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                                        <!--begin::Menu-->
                                        <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
                                            <div class="menu-item me-lg-1">
                                                <a class="menu-link active py-3" href="{{route('home')}}">
                                                    <span class="menu-title">Dashboard</span>
                                                </a>
                                            </div>
                                             <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
                                                <span class="menu-link py-3">
                                                    <span class="menu-title">Apps</span>
                                                    <span class="menu-arrow d-lg-none"></span>
                                                </span>
                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                        <span class="menu-link py-3">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/General/Shield-protected.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24" />
                                                                            <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
                                                                            <path d="M14.5,11 C15.0522847,11 15.5,11.4477153 15.5,12 L15.5,15 C15.5,15.5522847 15.0522847,16 14.5,16 L9.5,16 C8.94771525,16 8.5,15.5522847 8.5,15 L8.5,12 C8.5,11.4477153 8.94771525,11 9.5,11 L9.5,10.5 C9.5,9.11928813 10.6192881,8 12,8 C13.3807119,8 14.5,9.11928813 14.5,10.5 L14.5,11 Z M12,9 C11.1715729,9 10.5,9.67157288 10.5,10.5 L10.5,11 L13.5,11 L13.5,10.5 C13.5,9.67157288 12.8284271,9 12,9 Z" fill="#000000" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-title">User Management</span>
                                                            <span class="menu-arrow"></span>
                                                        </span>
                                                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Users</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="{{ route('users') }}">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Users List</span>
                                                                        </a>
                                                                    </div>
                                                                   <!--  <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/apps/user-management/users/view.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">View User</span>
                                                                        </a>
                                                                    </div> -->
                                                                </div>
                                                            </div>
                                                            <!-- roles list starts-->
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Event Management</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="{{ route('events') }}">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Events List</span>
                                                                        </a>
                                                                    </div>
                                                                  <!--   <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/apps/user-management/roles/view.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">View Roles</span>
                                                                        </a>
                                                                    </div> -->
                                                                </div>
                                                            </div>
                                                           <!-- role list ends -->
                                                        </div>
                                                    </div>
                                                    {{--
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion"></div>
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion"></div>
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion"></div>
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion"></div>
                                                    <div class="menu-item"></div>
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion"></div>
                                                    --}}

                                                </div>
                                            </div>




                                               {{-- 

                                                <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
                                                <span class="menu-link py-3">
                                                    <span class="menu-title">Crafted</span>
                                                    <span class="menu-arrow d-lg-none"></span>
                                                </span>
                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                        <span class="menu-link py-3">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
                                                                        <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-title">Pages</span>
                                                            <span class="menu-arrow"></span>
                                                        </span>
                                                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Profile</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/profile/overview.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Overview</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/profile/projects.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Projects</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/profile/campaigns.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Campaigns</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/profile/documents.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Documents</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/profile/connections.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Connections</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/profile/activity.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Activity</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Projects</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/projects/list.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">My Projects</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/projects/project.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">View Project</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/projects/targets.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Targets</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/projects/budget.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Budget</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/projects/users.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Users</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/projects/files.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Files</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/projects/activity.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Activity</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/projects/settings.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Settings</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Wizards</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/wizards/horizontal.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Horizontal</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/wizards/vertical.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Vertical</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Search</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/search/horizontal.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Horizontal</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/search/vertical.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Vertical</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Blog</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/blog/home.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Blog Home</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/blog/post.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Blog Post</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Company</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/company/about.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">About Us</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/company/pricing.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Pricing</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/company/contact.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Contact Us</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/company/team.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Our Team</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/company/licenses.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Licenses</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/company/sitemap.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Sitemap</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Careers</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/careers/list.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Careers List</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/careers/apply.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Careers Apply</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">FAQ</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/faq/classic.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Classic</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/pages/faq/extended.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Extended</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                        <span class="menu-link py-3">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                                            <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                                            <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-title">Account</span>
                                                            <span class="menu-arrow"></span>
                                                        </span>
                                                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/account/overview.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Overview</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/account/settings.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Settings</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/account/security.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Security</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/account/billing.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Billing</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/account/statements.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Statements</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/account/referrals.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Referrals</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/account/api-keys.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">API Keys</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                        <span class="menu-link py-3">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/Interface/Lock.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                        <path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M3.11117 13.2288C3.27137 11.0124 5.01376 9.29156 7.2315 9.15059C8.55778 9.06629 10.1795 9 12 9C13.8205 9 15.4422 9.06629 16.7685 9.15059C18.9862 9.29156 20.7286 11.0124 20.8888 13.2288C20.9535 14.1234 21 15.085 21 16C21 16.915 20.9535 17.8766 20.8888 18.7712C20.7286 20.9876 18.9862 22.7084 16.7685 22.8494C15.4422 22.9337 13.8205 23 12 23C10.1795 23 8.55778 22.9337 7.23151 22.8494C5.01376 22.7084 3.27137 20.9876 3.11118 18.7712C3.04652 17.8766 3 16.915 3 16C3 15.085 3.04652 14.1234 3.11117 13.2288Z" fill="#12131A" />
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13 16.7324C13.5978 16.3866 14 15.7403 14 15C14 13.8954 13.1046 13 12 13C10.8954 13 10 13.8954 10 15C10 15.7403 10.4022 16.3866 11 16.7324V18C11 18.5523 11.4477 19 12 19C12.5523 19 13 18.5523 13 18V16.7324Z" fill="#12131A" />
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 6C7 3.23858 9.23858 1 12 1C14.7614 1 17 3.23858 17 6V10C17 10.5523 16.5523 11 16 11C15.4477 11 15 10.5523 15 10V6C15 4.34315 13.6569 3 12 3C10.3431 3 9 4.34315 9 6V10C9 10.5523 8.55228 11 8 11C7.44772 11 7 10.5523 7 10V6Z" fill="#12131A" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-title">Authentication</span>
                                                            <span class="menu-arrow"></span>
                                                        </span>
                                                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Basic Flow</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/basic/sign-in.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Sign-in</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/basic/sign-up.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Sign-up</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/basic/two-steps.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Two-steps</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/basic/password-reset.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Password Reset</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/basic/new-password.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">New Password</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Aside Flow</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/aside/sign-in.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Sign-in</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/aside/sign-up.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Sign-up</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/aside/two-steps.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Two-steps</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/aside/password-reset.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Password Reset</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/aside/new-password.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">New Password</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Dark Flow</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/dark/sign-in.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Sign-in</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/dark/sign-up.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Sign-up</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/dark/two-steps.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Two-steps</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/dark/password-reset.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Password Reset</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/flows/dark/new-password.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">New Password</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Extended</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/extended/multi-steps-sign-up.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Multi-steps Sign-up</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/extended/free-trial-sign-up.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Free Trial Sign-up</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/extended/coming-soon.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Coming Soon</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/general/welcome.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Welcome Message</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/general/verify-email.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Verify Email</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/general/password-confirmation.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Password Confirmation</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/general/deactivation.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Account Deactivation</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/general/error-404.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Error 404</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/general/error-500.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Error 500</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Email Templates</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/email/verify-email.html" target="blank">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Verify Email</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/email/invitation.html" target="blank">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Account Invitation</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/email/password-reset.html" target="blank">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Password Reset</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/authentication/email/password-change.html" target="blank">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Password Changed</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                        <span class="menu-link py-3">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/Design/Substract.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <path d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z" fill="#000000" fill-rule="nonzero" />
                                                                        <path d="M10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L10.1818182,16 C8.76751186,16 8,15.2324881 8,13.8181818 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 Z" fill="#000000" opacity="0.3" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-title">Modals</span>
                                                            <span class="menu-arrow"></span>
                                                        </span>
                                                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">General</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/general/invite-friends.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Invite Friends</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/general/view-users.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">View Users</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/general/upgrade-plan.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Upgrade Plan</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/general/share-earn.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Share &amp; Earn</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Forms</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/forms/new-target.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">New Target</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/forms/new-card.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">New Card</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/forms/new-address.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">New Address</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/forms/create-api-key.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Create API Key</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Wizards</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/wizards/two-factor-authentication.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Two Factor Auth</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/wizards/create-app.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Create App</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/wizards/create-account.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Create Account</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/wizards/create-project.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Create Project</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/wizards/offer-a-deal.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Offer a Deal</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                                <span class="menu-link py-3">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Search</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/search/users.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Users</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="menu-item">
                                                                        <a class="menu-link py-3" href="../../demo1/dist/modals/search/select-location.html">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">Select Location</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                        <span class="menu-link py-3">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24" />
                                                                            <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
                                                                            <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-title">Widgets</span>
                                                            <span class="menu-arrow"></span>
                                                        </span>
                                                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/widgets/lists.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Lists</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/widgets/statistics.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Statistics</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/widgets/charts.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Charts</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/widgets/mixed.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Mixed</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/widgets/tables.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Tables</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/widgets/feeds.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Feeds</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                       
                                            <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
                                                <span class="menu-link py-3">
                                                    <span class="menu-title">Layouts</span>
                                                    <span class="menu-arrow d-lg-none"></span>
                                                </span>
                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                                        <span class="menu-link py-3">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/Shopping/Box2.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24" />
                                                                            <path d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z" fill="#000000" />
                                                                            <path d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z" fill="#000000" opacity="0.3" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-title">Toolbars</span>
                                                            <span class="menu-arrow"></span>
                                                        </span>
                                                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/layouts/toolbars/toolbar-1.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Toolbar 1</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/layouts/toolbars/toolbar-2.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Toolbar 2</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/layouts/toolbars/toolbar-3.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Toolbar 3</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/layouts/toolbars/toolbar-4.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Toolbar 4</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/layouts/toolbars/toolbar-5.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Toolbar 5</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-dropdown">
                                                        <span class="menu-link py-3">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/Home/Cupboard.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24" />
                                                                            <path d="M3.5,3 L9.5,3 C10.3284271,3 11,3.67157288 11,4.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L3.5,20 C2.67157288,20 2,19.3284271 2,18.5 L2,4.5 C2,3.67157288 2.67157288,3 3.5,3 Z M9,9 C8.44771525,9 8,9.44771525 8,10 L8,12 C8,12.5522847 8.44771525,13 9,13 C9.55228475,13 10,12.5522847 10,12 L10,10 C10,9.44771525 9.55228475,9 9,9 Z" fill="#000000" opacity="0.3" />
                                                                            <path d="M14.5,3 L20.5,3 C21.3284271,3 22,3.67157288 22,4.5 L22,18.5 C22,19.3284271 21.3284271,20 20.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,4.5 C13,3.67157288 13.6715729,3 14.5,3 Z M20,9 C19.4477153,9 19,9.44771525 19,10 L19,12 C19,12.5522847 19.4477153,13 20,13 C20.5522847,13 21,12.5522847 21,12 L21,10 C21,9.44771525 20.5522847,9 20,9 Z" fill="#000000" transform="translate(17.500000, 11.500000) scale(-1, 1) translate(-17.500000, -11.500000)" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-title">Aside</span>
                                                            <span class="menu-arrow"></span>
                                                        </span>
                                                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px">
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/layouts/aside/light.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Light Skin</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/layouts/aside/font-icons.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Font Icons</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/layouts/aside/minimized.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Minimized</span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a class="menu-link py-3" href="../../demo1/dist/layouts/aside/none.html">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">Without Aside</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
                                                <span class="menu-link py-3">
                                                    <span class="menu-title">Resources</span>
                                                    <span class="menu-arrow d-lg-none"></span>
                                                </span>
                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                                                    <div class="menu-item">
                                                        <a class="menu-link py-3" href="../../demo1/dist/documentation/base/utilities.html" title="Check out over 200 in-house components, plugins and ready for use solutions" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/Layout/Layout-arrange.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24" />
                                                                            <path d="M5.5,4 L9.5,4 C10.3284271,4 11,4.67157288 11,5.5 L11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L5.5,8 C4.67157288,8 4,7.32842712 4,6.5 L4,5.5 C4,4.67157288 4.67157288,4 5.5,4 Z M14.5,16 L18.5,16 C19.3284271,16 20,16.6715729 20,17.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,17.5 C13,16.6715729 13.6715729,16 14.5,16 Z" fill="#000000" />
                                                                            <path d="M5.5,10 L9.5,10 C10.3284271,10 11,10.6715729 11,11.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,12.5 C20,13.3284271 19.3284271,14 18.5,14 L14.5,14 C13.6715729,14 13,13.3284271 13,12.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z" fill="#000000" opacity="0.3" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-title">Components</span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a class="menu-link py-3" href="../../demo1/dist/documentation/getting-started.html" title="Check out the complete documentation" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/Home/Library.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24" />
                                                                            <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                            <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-title">Documentation</span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a class="menu-link py-3" href="https://preview.keenthemes.com/metronic8/demo1/layout-builder.html" title="Build your layout, preview and export HTML for server side integration" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/Interface/Settings-02.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                        <path opacity="0.25" d="M2 6.5C2 4.01472 4.01472 2 6.5 2H17.5C19.9853 2 22 4.01472 22 6.5V6.5C22 8.98528 19.9853 11 17.5 11H6.5C4.01472 11 2 8.98528 2 6.5V6.5Z" fill="#12131A" />
                                                                        <path d="M20 6.5C20 7.88071 18.8807 9 17.5 9C16.1193 9 15 7.88071 15 6.5C15 5.11929 16.1193 4 17.5 4C18.8807 4 20 5.11929 20 6.5Z" fill="#12131A" />
                                                                        <path opacity="0.25" d="M2 17.5C2 15.0147 4.01472 13 6.5 13H17.5C19.9853 13 22 15.0147 22 17.5V17.5C22 19.9853 19.9853 22 17.5 22H6.5C4.01472 22 2 19.9853 2 17.5V17.5Z" fill="#12131A" />
                                                                        <path d="M9 17.5C9 18.8807 7.88071 20 6.5 20C5.11929 20 4 18.8807 4 17.5C4 16.1193 5.11929 15 6.5 15C7.88071 15 9 16.1193 9 17.5Z" fill="#12131A" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-title">Layout Builder</span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a class="menu-link py-3" href="../../demo1/dist/documentation/getting-started/changelog.html">
                                                            <span class="menu-icon">
                                                                <!--begin::Svg Icon | path: icons/duotone/Files/File.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                                            <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                                            <rect fill="#000000" x="6" y="11" width="9" height="2" rx="1" />
                                                                            <rect fill="#000000" x="6" y="15" width="5" height="2" rx="1" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <span class="menu-title">Changelog v8.0.21</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
                                                <span class="menu-link py-3">
                                                    <span class="menu-title">Mega Menu</span>
                                                    <span class="menu-arrow d-lg-none"></span>
                                                </span>
                                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown w-100 w-lg-600px p-5 p-lg-5">
                                                    <!--begin:Row-->
                                                    <div class="row" data-kt-menu-dismiss="true">
                                                        <!--begin:Col-->
                                                        <div class="col-lg-4 border-left-lg-1">
                                                            <div class="menu-inline menu-column menu-active-bg">
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end:Col-->
                                                        <!--begin:Col-->
                                                        <div class="col-lg-4 border-left-lg-1">
                                                            <div class="menu-inline menu-column menu-active-bg">
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end:Col-->
                                                        <!--begin:Col-->
                                                        <div class="col-lg-4 border-left-lg-1">
                                                            <div class="menu-inline menu-column menu-active-bg">
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="#" class="menu-link">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span class="menu-title">Example link</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end:Col-->
                                                    </div>
                                                    <!--end:Row-->
                                                </div>
                                            </div> 

                                            --}}




                                        </div>
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::Menu wrapper-->
                                </div>
                                <!--end::Navbar-->
                                <!--begin::Topbar-->
                                <div class="d-flex align-items-stretch flex-shrink-0">
                                    <!--begin::Toolbar wrapper-->
                                    <div class="d-flex align-items-stretch flex-shrink-0">
                                        
                                       
                                        <!--begin::User-->
                                        <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                                            <!--begin::Menu wrapper-->
                                            <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                                                @php $logUser=auth()->User(); @endphp
                                                <img src="{{ url('assets/media/avatars/blank.png')}}" alt="metronic" />
                                            </div>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <div class="menu-content d-flex align-items-center px-3">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-50px me-5">
                                                            <img alt="Logo" src="{{ url('assets/media/avatars/blank.png')}}" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Username-->
                                                        <div class="d-flex flex-column">
                                                            <div class="fw-bolder d-flex align-items-center fs-5">{{ $logUser->name  ?? ''}}
                                                            <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span></div>
                                                            <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{ $logUser-> email  ?? ''}}</a>
                                                        </div>
                                                        <!--end::Username-->
                                                    </div>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu separator-->
                                                <div class="separator my-2"></div>
                                                <!--end::Menu separator-->
                                                <!--begin::Menu item-->

                                                <!--  <div class="menu-item px-5">
                                                    <a href="" class="menu-link px-5">My Profile</a>
                                                </div> -->

                                                <!--end::Menu item-->
                                               
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start" data-kt-menu-flip="bottom"></div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-5"></div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu separator-->
                                                <div class="separator my-2"></div>
                                                <!--end::Menu separator-->
                                                <!--begin::Menu item-->
                                              {{--  <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start" data-kt-menu-flip="bottom">
                                                    <a href="#" class="menu-link px-5">
                                                        <span class="menu-title position-relative">Language
                                                        <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">English
                                                        <img class="w-15px h-15px rounded-1 ms-2" src="assets/media/flags/united-states.svg" alt="metronic" /></span></span>
                                                    </a>
                                                    <!--begin::Menu sub-->
                                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/account/settings.html" class="menu-link d-flex px-5 active">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1" src="assets/media/flags/united-states.svg" alt="metronic" />
                                                            </span>English</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/account/settings.html" class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1" src="assets/media/flags/spain.svg" alt="metronic" />
                                                            </span>Spanish</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/account/settings.html" class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1" src="assets/media/flags/germany.svg" alt="metronic" />
                                                            </span>German</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/account/settings.html" class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1" src="assets/media/flags/japan.svg" alt="metronic" />
                                                            </span>Japanese</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="../../demo1/dist/account/settings.html" class="menu-link d-flex px-5">
                                                            <span class="symbol symbol-20px me-4">
                                                                <img class="rounded-1" src="assets/media/flags/france.svg" alt="metronic" />
                                                            </span>French</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu sub-->
                                                </div> --}}
                                                <!--end::Menu item-->
                                              
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-5">
                                                  
                                                     <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Sign Out') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu separator-->
                                                <div class="separator my-2"></div>
                                                <!--end::Menu separator-->
                                           
                                              
                                            </div>
                                            <!--end::Menu-->
                                            <!--end::Menu wrapper-->
                                        </div>
                                        <!--end::User -->
                                        <!--begin::Heaeder menu toggle-->
                                        <div class="d-flex align-items-center d-lg-none ms-2 me-n3" title="Show header menu">
                                            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
                                                <!--begin::Svg Icon | path: icons/duotone/Text/Toggle-Right.svg-->
                                                <span class="svg-icon svg-icon-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22 11.5C22 12.3284 21.3284 13 20.5 13H3.5C2.6716 13 2 12.3284 2 11.5C2 10.6716 2.6716 10 3.5 10H20.5C21.3284 10 22 10.6716 22 11.5Z" fill="black" />
                                                            <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M14.5 20C15.3284 20 16 19.3284 16 18.5C16 17.6716 15.3284 17 14.5 17H3.5C2.6716 17 2 17.6716 2 18.5C2 19.3284 2.6716 20 3.5 20H14.5ZM8.5 6C9.3284 6 10 5.32843 10 4.5C10 3.67157 9.3284 3 8.5 3H3.5C2.6716 3 2 3.67157 2 4.5C2 5.32843 2.6716 6 3.5 6H8.5Z" fill="black" />
                                                        </g>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </div>
                                        </div>
                                        <!--end::Heaeder menu toggle-->
                                    </div>
                                    <!--end::Toolbar wrapper-->
                                </div>
                                <!--end::Topbar-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                      @yield('content')
                    </div>
                    <!--end::Content-->
                    <!--begin::Footer-->
                    <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                        <!--begin::Container-->
                        <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <!--begin::Copyright-->
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted fw-bold me-1">2021©</span>
                                <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Keenthemes</a>
                            </div>
                            <!--end::Copyright-->
                            <!--begin::Menu-->
                            <ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
                                <li class="menu-item">
                                    <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
                                </li>
                                <li class="menu-item">
                                    <a href="https://keenthemes.com/support" target="_blank" class="menu-link px-2">Support</a>
                                </li>
                                <li class="menu-item">
                                    <a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
                                </li>
                            </ul>
                            <!--end::Menu-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Footer-->
                </div>