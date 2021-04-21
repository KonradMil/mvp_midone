<template>
    <!-- BEGIN: Mobile Menu -->
    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="" class="flex mr-auto">
                <img alt="Rubick Tailwind HTML Admin Template" class="w-6" src="dist/images/logo.svg">
            </a>
            <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        </div>
        <ul class="border-t border-theme-29 py-5 hidden">
            <li>
                <a href="javascript:" class="menu">
                    <div class="menu__icon"> <i data-feather="home"></i> </div>
                    <div class="menu__title"> Dashboard <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="side-menu-dark-dashboard-overview-1.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Overview 1 </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-dashboard-overview-2.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Overview 2 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="box"></i> </div>
                    <div class="menu__title"> Menu Layout <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="side-menu-dark-dashboard-overview-1.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Side Menu </div>
                        </a>
                    </li>
                    <li>
                        <a href="simple-menu-dark-dashboard-overview-1.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Simple Menu </div>
                        </a>
                    </li>
                    <li>
                        <a href="top-menu-dark-dashboard-overview-1.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Top Menu </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="side-menu-dark-inbox.html" class="menu">
                    <div class="menu__icon"> <i data-feather="inbox"></i> </div>
                    <div class="menu__title"> Inbox </div>
                </a>
            </li>
            <li>
                <a href="side-menu-dark-file-manager.html" class="menu">
                    <div class="menu__icon"> <i data-feather="hard-drive"></i> </div>
                    <div class="menu__title"> File Manager </div>
                </a>
            </li>
            <li>
                <a href="side-menu-dark-point-of-sale.html" class="menu">
                    <div class="menu__icon"> <i data-feather="credit-card"></i> </div>
                    <div class="menu__title"> Point of Sale </div>
                </a>
            </li>
            <li>
                <a href="side-menu-dark-chat.html" class="menu">
                    <div class="menu__icon"> <i data-feather="message-square"></i> </div>
                    <div class="menu__title"> Chat </div>
                </a>
            </li>
            <li>
                <a href="side-menu-dark-post.html" class="menu">
                    <div class="menu__icon"> <i data-feather="file-text"></i> </div>
                    <div class="menu__title"> Post </div>
                </a>
            </li>
            <li>
                <a href="side-menu-dark-calendar.html" class="menu">
                    <div class="menu__icon"> <i data-feather="calendar"></i> </div>
                    <div class="menu__title"> Calendar </div>
                </a>
            </li>
            <li class="menu__devider my-6"></li>
            <li>
                <a href="javascript:" class="menu menu--active">
                    <div class="menu__icon"> <i data-feather="edit"></i> </div>
                    <div class="menu__title"> Crud <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>
                <ul class="menu__sub-open">
                    <li>
                        <a href="side-menu-dark-crud-data-list.html" class="menu menu--active">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Data List </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-crud-form.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Form </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="users"></i> </div>
                    <div class="menu__title"> Users <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="side-menu-dark-users-layout-1.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Layout 1 </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-users-layout-2.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Layout 2 </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-users-layout-3.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Layout 3 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="trello"></i> </div>
                    <div class="menu__title"> Profile <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="side-menu-dark-profile-overview-1.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Overview 1 </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-profile-overview-2.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Overview 2 </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-profile-overview-3.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Overview 3 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="layout"></i> </div>
                    <div class="menu__title"> Pages <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Wizards <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-wizard-layout-1.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 1</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-wizard-layout-2.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 2</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-wizard-layout-3.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 3</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Blog <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-blog-layout-1.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 1</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-blog-layout-2.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 2</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-blog-layout-3.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 3</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Pricing <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-pricing-layout-1.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 1</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-pricing-layout-2.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 2</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Invoice <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-invoice-layout-1.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 1</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-invoice-layout-2.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 2</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> FAQ <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-faq-layout-1.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 1</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-faq-layout-2.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 2</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-faq-layout-3.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Layout 3</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="login-dark-login.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Login </div>
                        </a>
                    </li>
                    <li>
                        <a href="login-dark-register.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Register </div>
                        </a>
                    </li>
                    <li>
                        <a href="main-dark-error-page.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Error Page </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-update-profile.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Update profile </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-change-password.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Change Password </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu__devider my-6"></li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="inbox"></i> </div>
                    <div class="menu__title"> Components <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Table <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-regular-table.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Regular Table</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-tabulator.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Tabulator</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Overlay <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="side-menu-dark-modal.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Modal</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-slide-over.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Slide Over</div>
                                </a>
                            </li>
                            <li>
                                <a href="side-menu-dark-notification.html" class="menu">
                                    <div class="menu__icon"> <i data-feather="zap"></i> </div>
                                    <div class="menu__title">Notification</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="side-menu-dark-accordion.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Accordion </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-button.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Button </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-alert.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Alert </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-progress-bar.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Progress Bar </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-tooltip.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Tooltip </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-dropdown.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Dropdown </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-typography.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Typography </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-icon.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Icon </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-loading-icon.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Loading Icon </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="sidebar"></i> </div>
                    <div class="menu__title"> Forms <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="side-menu-dark-regular-form.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Regular Form </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-datepicker.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Datepicker </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-tail-select.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Tail Select </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-file-upload.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> File Upload </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-wysiwyg-editor.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Wysiwyg Editor </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-validation.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Validation </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="hard-drive"></i> </div>
                    <div class="menu__title"> Widgets <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="side-menu-dark-chart.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Chart </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-slider.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Slider </div>
                        </a>
                    </li>
                    <li>
                        <a href="side-menu-dark-image-zoom.html" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Image Zoom </div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- END: Mobile Menu -->
    <div class="flex">
        <!-- BEGIN: Content -->
        <div class="content">
            <h2 class="intro-y text-lg font-medium mt-10">
                Data List Layout
            </h2>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <button class="btn btn-primary shadow-md mr-2">Add New Product</button>
                    <div class="dropdown">
                        <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                        </button>
                        <div class="dropdown-menu w-40">
                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print </a>
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block mx-auto text-gray-600">Showing 1 to 10 of 150 entries</div>
                    <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                        <div class="w-56 relative text-gray-700 dark:text-gray-300">
                            <input type="text" class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
                        </div>
                    </div>
                </div>
                <!-- BEGIN: Data List -->
                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible"
                >
                    <table class="table table-report -mt-2"

                    >
                        <thead>
                        <tr>
                            <th class="whitespace-nowrap">Avatar</th>
                            <th class="whitespace-nowrap"><Dane></Dane></th>
                            <th class="text-center whitespace-nowrap">STOCK</th>
                            <th class="text-center whitespace-nowrap">STATUS</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="intro-x"  v-for="(user, index) in users.list"
                            :key="index">
                            <td class="w-40">
                                <div class="flex">
                                    <Avatar :src="'uploads/' + user.avatar" :username="user.name + ' ' + user.lastname" size="60"
                                            color="#FFF" background-color="#930f68"/>
                                </div>
                            </td>
                            <td>
                                <button @click="$router.push('profiles')" class="font-medium whitespace-nowrap">{{ user.name + ' ' + user.lastname }}</button>
                                <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{user.type}}</div>
                            </td>
                            <td class="text-center">50</td>
                            <td class="w-40">
                                <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3" href="javascript:;"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                    <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- END: Data List -->
                <!-- BEGIN: Pagination -->
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                    <ul class="pagination">
                        <li>
                            <a class="pagination__link" href=""> <i class="w-4 h-4" data-feather="chevrons-left"></i> </a>
                        </li>
                        <li>
                            <a class="pagination__link" href=""> <i class="w-4 h-4" data-feather="chevron-left"></i> </a>
                        </li>
                        <li> <a class="pagination__link" href="">...</a> </li>
                        <li> <a class="pagination__link" href="">1</a> </li>
                        <li> <a class="pagination__link pagination__link--active" href="">2</a> </li>
                        <li> <a class="pagination__link" href="">3</a> </li>
                        <li> <a class="pagination__link" href="">...</a> </li>
                        <li>
                            <a class="pagination__link" href=""> <i class="w-4 h-4" data-feather="chevron-right"></i> </a>
                        </li>
                        <li>
                            <a class="pagination__link" href=""> <i class="w-4 h-4" data-feather="chevrons-right"></i> </a>
                        </li>
                    </ul>
                    <select class="w-20 form-select box mt-3 sm:mt-0">
                        <option>10</option>
                        <option>25</option>
                        <option>35</option>
                        <option>50</option>
                    </select>
                </div>
                <!-- END: Pagination -->
            </div>
            <!-- BEGIN: Delete Confirmation Modal -->
            <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="p-5 text-center">
                                <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                <div class="text-3xl mt-5">Are you sure?</div>
                                <div class="text-gray-600 mt-2">
                                    Do you really want to delete these records?
                                    <br>
                                    This process cannot be undone.
                                </div>
                            </div>
                            <div class="px-5 pb-8 text-center">
                                <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                <button type="button" class="btn btn-danger w-24">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Delete Confirmation Modal -->
        </div>
        <!-- END: Content -->
    </div>
    <!-- BEGIN: Dark Mode Switcher-->
    <div data-url="side-menu-light-crud-data-list.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
        <div class="mr-4 text-gray-700 dark:text-gray-300">Dark Mode</div>
        <div class="dark-mode-switcher__toggle dark-mode-switcher__toggle--active border"></div>
    </div>
    <!-- END: Dark Mode Switcher-->
    <!-- BEGIN: JS Assets-->
</template>

<script>
import {onMounted, ref} from "vue";
import GetUsers from '../../compositions/GetUsers'
import {useToast} from "vue-toastification";
import Avatar from "../../components/avatar/Avatar";
import Modal from "../../components/Modal";


export default {
    name: "Teams",
    components: {Avatar, Modal, GetUsers},
    setup(props, {emit}) {
        // const user = ref({});
        const toast = useToast();
        const users = ref([]);

        const getUsersRepositories = async () => {
            users.value = GetUsers();
        }
        onMounted(function () {
            getUsersRepositories('');
            // if (window.Laravel.user) {
            //     user.value = window.Laravel.user;
            // }
        })
        return {
            users,
            // user,
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>

<style scoped>

</style>
