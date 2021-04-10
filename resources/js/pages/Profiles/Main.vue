<template>
    <div class="flex">
        <!-- BEGIN: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            <!-- BEGIN: Top Bar -->
            <div class="top-bar">
                <!-- BEGIN: Breadcrumb -->
                <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Application</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Dashboard</a> </div>
                <!-- END: Breadcrumb -->
                <!-- BEGIN: Search -->
                <div class="intro-x relative mr-3 sm:mr-6">
                    <div class="search hidden sm:block">
                        <input type="text" class="search__input form-control border-transparent placeholder-theme-13" placeholder="Search...">
                        <i data-feather="search" class="search__icon dark:text-gray-300"></i>
                    </div>
                    <a class="notification sm:hidden" href=""> <i data-feather="search" class="notification__icon dark:text-gray-300"></i> </a>
                    <div class="search-result">
                        <div class="search-result__content">
                            <div class="search-result__content__title">Pages</div>
                            <div class="mb-5">
                                <a href="" class="flex items-center">
                                    <div class="w-8 h-8 bg-theme-18 text-theme-9 flex items-center justify-center rounded-full"> <i class="w-4 h-4" data-feather="inbox"></i> </div>
                                    <div class="ml-3">Mail Settings</div>
                                </a>
                                <a href="" class="flex items-center mt-2">
                                    <div class="w-8 h-8 bg-theme-17 text-theme-11 flex items-center justify-center rounded-full"> <i class="w-4 h-4" data-feather="users"></i> </div>
                                    <div class="ml-3">Users & Permissions</div>
                                </a>
                                <a href="" class="flex items-center mt-2">
                                    <div class="w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full"> <i class="w-4 h-4" data-feather="credit-card"></i> </div>
                                    <div class="ml-3">Transactions Report</div>
                                </a>
                            </div>
                            <div class="search-result__content__title">Users</div>
                            <div class="mb-5">
                                <a href="" class="flex items-center mt-2">
                                    <div class="w-8 h-8 image-fit">
                                        <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-9.jpg">
                                    </div>
                                    <div class="ml-3">Brad Pitt</div>
                                    <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">bradpitt@left4code.com</div>
                                </a>
                                <a href="" class="flex items-center mt-2">
                                    <div class="w-8 h-8 image-fit">
                                        <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-9.jpg">
                                    </div>
                                    <div class="ml-3">Al Pacino</div>
                                    <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">alpacino@left4code.com</div>
                                </a>
                                <a href="" class="flex items-center mt-2">
                                    <div class="w-8 h-8 image-fit">
                                        <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-15.jpg">
                                    </div>
                                    <div class="ml-3">Leonardo DiCaprio</div>
                                    <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">leonardodicaprio@left4code.com</div>
                                </a>
                                <a href="" class="flex items-center mt-2">
                                    <div class="w-8 h-8 image-fit">
                                        <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-12.jpg">
                                    </div>
                                    <div class="ml-3">Leonardo DiCaprio</div>
                                    <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">leonardodicaprio@left4code.com</div>
                                </a>
                            </div>
                            <div class="search-result__content__title">Products</div>
                            <a href="" class="flex items-center mt-2">
                                <div class="w-8 h-8 image-fit">
                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/preview-11.jpg">
                                </div>
                                <div class="ml-3">Samsung Q90 QLED TV</div>
                                <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">Electronic</div>
                            </a>
                            <a href="" class="flex items-center mt-2">
                                <div class="w-8 h-8 image-fit">
                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/preview-10.jpg">
                                </div>
                                <div class="ml-3">Apple MacBook Pro 13</div>
                                <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">PC &amp; Laptop</div>
                            </a>
                            <a href="" class="flex items-center mt-2">
                                <div class="w-8 h-8 image-fit">
                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/preview-9.jpg">
                                </div>
                                <div class="ml-3">Samsung Q90 QLED TV</div>
                                <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">Electronic</div>
                            </a>
                            <a href="" class="flex items-center mt-2">
                                <div class="w-8 h-8 image-fit">
                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/preview-12.jpg">
                                </div>
                                <div class="ml-3">Sony Master Series A9G</div>
                                <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">Electronic</div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- END: Search -->
                <!-- BEGIN: Notifications -->
                <div class="intro-x dropdown mr-auto sm:mr-6">
                    <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button" aria-expanded="false"> <i data-feather="bell" class="notification__icon dark:text-gray-300"></i> </div>
                    <div class="notification-content pt-2 dropdown-menu">
                        <div class="notification-content__box dropdown-menu__content box dark:bg-dark-6">
                            <div class="notification-content__title">Notifications</div>
                            <div class="cursor-pointer relative flex items-center ">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-9.jpg">
                                    <div class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <a href="javascript:;" class="font-medium truncate mr-5">Brad Pitt</a>
                                        <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">06:05 AM</div>
                                    </div>
                                    <div class="w-full truncate text-gray-600 mt-0.5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500</div>
                                </div>
                            </div>
                            <div class="cursor-pointer relative flex items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-9.jpg">
                                    <div class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <a href="javascript:;" class="font-medium truncate mr-5">Al Pacino</a>
                                        <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">05:09 AM</div>
                                    </div>
                                    <div class="w-full truncate text-gray-600 mt-0.5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500</div>
                                </div>
                            </div>
                            <div class="cursor-pointer relative flex items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-15.jpg">
                                    <div class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <a href="javascript:;" class="font-medium truncate mr-5">Leonardo DiCaprio</a>
                                        <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">05:09 AM</div>
                                    </div>
                                    <div class="w-full truncate text-gray-600 mt-0.5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500</div>
                                </div>
                            </div>
                            <div class="cursor-pointer relative flex items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-12.jpg">
                                    <div class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <a href="javascript:;" class="font-medium truncate mr-5">Leonardo DiCaprio</a>
                                        <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">01:10 PM</div>
                                    </div>
                                    <div class="w-full truncate text-gray-600 mt-0.5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem </div>
                                </div>
                            </div>
                            <div class="cursor-pointer relative flex items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-8.jpg">
                                    <div class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <a href="javascript:;" class="font-medium truncate mr-5">Brad Pitt</a>
                                        <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">01:10 PM</div>
                                    </div>
                                    <div class="w-full truncate text-gray-600 mt-0.5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Notifications -->
                <!-- BEGIN: Account Menu -->
                <div class="intro-x dropdown w-8 h-8">
                    <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false">
                        <img alt="Rubick Tailwind HTML Admin Template" src="dist/images/profile-8.jpg">
                    </div>
                    <div class="dropdown-menu w-56">
                        <div class="dropdown-menu__content box bg-theme-26 dark:bg-dark-6 text-white">
                            <div class="p-4 border-b border-theme-27 dark:border-dark-3">
                                <div class="font-medium">Brad Pitt</div>
                                <div class="text-xs text-theme-28 mt-0.5 dark:text-gray-600">DevOps Engineer</div>
                            </div>
                            <div class="p-2">
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile </a>
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="edit" class="w-4 h-4 mr-2"></i> Add Account </a>
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="help-circle" class="w-4 h-4 mr-2"></i> Help </a>
                            </div>
                            <div class="p-2 border-t border-theme-27 dark:border-dark-3">
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Account Menu -->
            </div>
            <!-- END: Top Bar -->
            <div class="intro-y flex items-center mt-8">
                <h2 class="text-lg font-medium mr-auto">
                    Profile Layout
                </h2>
            </div>
            <!-- BEGIN: Profile Info -->
            <div class="intro-y box px-5 pt-5 mt-5">
                <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
                    <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                            <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-11.jpg">
                        </div>
                        <div class="ml-5">
                            <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">Al Pacino</div>
                            <div class="text-gray-600">Backend Engineer</div>
                        </div>
                    </div>
                    <div class="mt-6 lg:mt-0 flex-1 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
                        <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>
                        <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                            <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="mail" class="w-4 h-4 mr-2"></i> alpacino@left4code.com </div>
                            <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="instagram" class="w-4 h-4 mr-2"></i> Instagram Al Pacino </div>
                            <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="twitter" class="w-4 h-4 mr-2"></i> Twitter Al Pacino </div>
                        </div>
                    </div>
                    <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-gray-200 dark:border-dark-5 pt-5 lg:pt-0">
                        <div class="text-center rounded-md w-20 py-3">
                            <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">201</div>
                            <div class="text-gray-600">Orders</div>
                        </div>
                        <div class="text-center rounded-md w-20 py-3">
                            <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">1k</div>
                            <div class="text-gray-600">Purchases</div>
                        </div>
                        <div class="text-center rounded-md w-20 py-3">
                            <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">492</div>
                            <div class="text-gray-600">Reviews</div>
                        </div>
                    </div>
                </div>
                <div class="nav nav-tabs flex-col sm:flex-row justify-center lg:justify-start" role="tablist">
                    <a id="profile-tab" data-toggle="tab" data-target="#profile" href="javascript:;" class="py-4 sm:mr-8 flex items-center active" role="tab" aria-controls="profile" aria-selected="true"> <i class="w-4 h-4 mr-2" data-feather="user"></i> Profile </a>
                    <a id="account-tab" data-toggle="tab" data-target="#account" href="javascript:;" class="py-4 sm:mr-8 flex items-center" role="tab" aria-selected="false"> <i class="w-4 h-4 mr-2" data-feather="shield"></i> Account </a>
                    <a id="change-password-tab" data-toggle="tab" data-target="#change-password" href="javascript:;" class="py-4 sm:mr-8 flex items-center" role="tab" aria-selected="false"> <i class="w-4 h-4 mr-2" data-feather="lock"></i> Change Password </a>
                    <a id="settings-tab" data-toggle="tab" data-target="#settings" href="javascript:;" class="py-4 sm:mr-8 flex items-center" role="tab" aria-selected="false"> <i class="w-4 h-4 mr-2" data-feather="settings"></i> Settings </a>
                </div>
            </div>
            <!-- END: Profile Info -->
            <div class="tab-content mt-5">
                <div id="profile" class="tab-pane active" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="grid grid-cols-12 gap-6">
                        <!-- BEGIN: Latest Uploads -->
                        <div class="intro-y box col-span-12 lg:col-span-6">
                            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">
                                    Latest Uploads
                                </h2>
                                <div class="dropdown ml-auto sm:hidden">
                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i> </a>
                                    <div class="dropdown-menu w-40">
                                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2"> <a href="javascript:;" class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">All Files</a> </div>
                                    </div>
                                </div>
                                <button class="btn btn-outline-secondary hidden sm:flex">All Files</button>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="file"> <a href="" class="w-12 file__icon file__icon--directory"></a> </div>
                                    <div class="ml-4">
                                        <a class="font-medium" href="">Documentation</a>
                                        <div class="text-gray-600 text-xs mt-0.5">40 KB</div>
                                    </div>
                                    <div class="dropdown ml-auto">
                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i> </a>
                                        <div class="dropdown-menu w-40">
                                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="users" class="w-4 h-4 mr-2"></i> Share File </a>
                                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center mt-5">
                                    <div class="file">
                                        <a href="" class="w-12 file__icon file__icon--file">
                                            <div class="file__icon__file-name text-xs">MP3</div>
                                        </a>
                                    </div>
                                    <div class="ml-4">
                                        <a class="font-medium" href="">Celine Dion - Ashes</a>
                                        <div class="text-gray-600 text-xs mt-0.5">40 KB</div>
                                    </div>
                                    <div class="dropdown ml-auto">
                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i> </a>
                                        <div class="dropdown-menu w-40">
                                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="users" class="w-4 h-4 mr-2"></i> Share File </a>
                                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center mt-5">
                                    <div class="file"> <a href="" class="w-12 file__icon file__icon--empty-directory"></a> </div>
                                    <div class="ml-4">
                                        <a class="font-medium" href="">Resources</a>
                                        <div class="text-gray-600 text-xs mt-0.5">0 KB</div>
                                    </div>
                                    <div class="dropdown ml-auto">
                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i> </a>
                                        <div class="dropdown-menu w-40">
                                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="users" class="w-4 h-4 mr-2"></i> Share File </a>
                                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="trash" class="w-4 h-4 mr-2"></i> Delete </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Latest Uploads -->
                        <!-- BEGIN: Work In Progress -->
                        <div class="intro-y box col-span-12 lg:col-span-6">
                            <div class="flex items-center px-5 py-5 sm:py-0 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">
                                    Work In Progress
                                </h2>
                                <div class="dropdown ml-auto sm:hidden">
                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i> </a>
                                    <div class="nav nav-tabs dropdown-menu w-40" role="tablist">
                                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2"> <a id="work-in-progress-new-tab" href="javascript:;" data-toggle="tab" data-target="#work-in-progress-new" class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md" role="tab" aria-controls="work-in-progress-new" aria-selected="true">New</a> <a id="work-in-progress-last-week-tab" href="javascript:;" data-toggle="tab" data-target="#work-in-progress-last-week" class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md" role="tab" aria-selected="false">Last Week</a> </div>
                                    </div>
                                </div>
                                <div class="nav nav-tabs ml-auto hidden sm:flex" role="tablist"> <a id="work-in-progress-mobile-new-tab" data-toggle="tab" data-target="#work-in-progress-new" href="javascript:;" class="py-5 ml-6 active" role="tab" aria-selected="true">New</a> <a id="week-work-in-progress-mobile-last-week-tab" data-toggle="tab" data-target="#work-in-progress-last-week" href="javascript:;" class="py-5 ml-6" role="tab" aria-selected="false">Last Week</a> </div>
                            </div>
                            <div class="p-5">
                                <div class="tab-content">
                                    <div id="work-in-progress-new" class="tab-pane active" role="tabpanel" aria-labelledby="work-in-progress-new-tab">
                                        <div>
                                            <div class="flex">
                                                <div class="mr-auto">Pending Tasks</div>
                                                <div>20%</div>
                                            </div>
                                            <div class="progress h-1 mt-2">
                                                <div class="progress-bar w-1/2 bg-theme-1" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="mt-5">
                                            <div class="flex">
                                                <div class="mr-auto">Completed Tasks</div>
                                                <div>2 / 20</div>
                                            </div>
                                            <div class="progress h-1 mt-2">
                                                <div class="progress-bar w-1/4 bg-theme-1" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="mt-5">
                                            <div class="flex">
                                                <div class="mr-auto">Tasks In Progress</div>
                                                <div>42</div>
                                            </div>
                                            <div class="progress h-1 mt-2">
                                                <div class="progress-bar w-3/4 bg-theme-1" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <a href="" class="btn btn-secondary block w-40 mx-auto mt-5">View More Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Work In Progress -->
                        <!-- BEGIN: Daily Sales -->
                        <div class="intro-y box col-span-12 lg:col-span-6">
                            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">
                                    Daily Sales
                                </h2>
                                <div class="dropdown ml-auto sm:hidden">
                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i> </a>
                                    <div class="dropdown-menu w-40">
                                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                            <a href="javascript:;" class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 rounded-md"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Excel </a>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-outline-secondary hidden sm:flex"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Excel </button>
                            </div>
                            <div class="p-5">
                                <div class="relative flex items-center">
                                    <div class="w-12 h-12 flex-none image-fit">
                                        <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-11.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <a href="" class="font-medium">Al Pacino</a>
                                        <div class="text-gray-600 mr-5 sm:mr-5">Bootstrap 4 HTML Admin Template</div>
                                    </div>
                                    <div class="font-medium text-gray-700 dark:text-gray-600">+$19</div>
                                </div>
                                <div class="relative flex items-center mt-5">
                                    <div class="w-12 h-12 flex-none image-fit">
                                        <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-14.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <a href="" class="font-medium">Denzel Washington</a>
                                        <div class="text-gray-600 mr-5 sm:mr-5">Tailwind HTML Admin Template</div>
                                    </div>
                                    <div class="font-medium text-gray-700 dark:text-gray-600">+$25</div>
                                </div>
                                <div class="relative flex items-center mt-5">
                                    <div class="w-12 h-12 flex-none image-fit">
                                        <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-11.jpg">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <a href="" class="font-medium">Brad Pitt</a>
                                        <div class="text-gray-600 mr-5 sm:mr-5">Vuejs HTML Admin Template</div>
                                    </div>
                                    <div class="font-medium text-gray-700 dark:text-gray-600">+$21</div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Daily Sales -->
                        <!-- BEGIN: Latest Tasks -->
                        <div class="intro-y box col-span-12 lg:col-span-6">
                            <div class="flex items-center px-5 py-5 sm:py-0 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">
                                    Latest Tasks
                                </h2>
                                <div class="dropdown ml-auto sm:hidden">
                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i> </a>
                                    <div class="nav nav-tabs dropdown-menu w-40" role="tablist">
                                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2"> <a id="latest-tasks-new-tab" href="javascript:;" data-toggle="tab" data-target="#latest-tasks-new" class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md" role="tab" aria-controls="latest-tasks-new" aria-selected="true">New</a> <a id="latest-tasks-last-week-tab" href="javascript:;" data-toggle="tab" data-target="#latest-tasks-last-week" class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md" role="tab" aria-selected="false">Last Week</a> </div>
                                    </div>
                                </div>
                                <div class="nav nav-tabs ml-auto hidden sm:flex" role="tablist"> <a id="latest-tasks-mobile-new-tab" data-toggle="tab" data-target="#latest-tasks-new" href="javascript:;" class="py-5 ml-6 active" role="tab" aria-selected="true">New</a> <a id="latest-tasks-mobile-last-week-tab" data-toggle="tab" data-target="#latest-tasks-last-week" href="javascript:;" class="py-5 ml-6" role="tab" aria-selected="false">Last Week</a> </div>
                            </div>
                            <div class="p-5">
                                <div class="tab-content">
                                    <div id="latest-tasks-new" class="tab-pane active" role="tabpanel" aria-labelledby="latest-tasks-new-tab">
                                        <div class="flex items-center">
                                            <div class="border-l-2 border-theme-1 pl-4">
                                                <a href="" class="font-medium">Create New Campaign</a>
                                                <div class="text-gray-600">10:00 AM</div>
                                            </div>
                                            <input class="form-check-switch ml-auto" type="checkbox">
                                        </div>
                                        <div class="flex items-center mt-5">
                                            <div class="border-l-2 border-theme-1 pl-4">
                                                <a href="" class="font-medium">Meeting With Client</a>
                                                <div class="text-gray-600">02:00 PM</div>
                                            </div>
                                            <input class="form-check-switch ml-auto" type="checkbox">
                                        </div>
                                        <div class="flex items-center mt-5">
                                            <div class="border-l-2 border-theme-1 pl-4">
                                                <a href="" class="font-medium">Create New Repository</a>
                                                <div class="text-gray-600">04:00 PM</div>
                                            </div>
                                            <input class="form-check-switch ml-auto" type="checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Latest Tasks -->
                        <!-- BEGIN: New Products -->
                        <div class="intro-y box col-span-12">
                            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">
                                    New Products
                                </h2>
                                <button data-carousel="new-products" data-target="prev" class="tiny-slider-navigator btn btn-outline-secondary px-2 mr-2"> <i data-feather="chevron-left" class="w-4 h-4"></i> </button>
                                <button data-carousel="new-products" data-target="next" class="tiny-slider-navigator btn btn-outline-secondary px-2"> <i data-feather="chevron-right" class="w-4 h-4"></i> </button>
                            </div>
                            <div id="new-products" class="tiny-slider py-5">
                                <div class="px-5">
                                    <div class="flex flex-col lg:flex-row items-center pb-5">
                                        <div class="flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                                            <div class="sm:mr-5">
                                                <div class="w-20 h-20 image-fit">
                                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/preview-7.jpg">
                                                </div>
                                            </div>
                                            <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                                <a href="" class="font-medium text-lg">Sony A7 III</a>
                                                <div class="text-gray-600 mt-1 sm:mt-0">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomi</div>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">114</div>
                                                <div class="text-gray-600">Orders</div>
                                            </div>
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">105k</div>
                                                <div class="text-gray-600">Purchases</div>
                                            </div>
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">114</div>
                                                <div class="text-gray-600">Reviews</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 dark:border-dark-5 pt-5">
                                        <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 dark:border-dark-5 pb-5 sm:pb-0">
                                            <div class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium mr-3">29 August 2022</div>
                                            <div class="text-gray-600">Date of Release</div>
                                        </div>
                                        <div class="flex sm:ml-auto mt-5 sm:mt-0">
                                            <button class="btn btn-secondary w-20 ml-auto">Preview</button>
                                            <button class="btn btn-secondary w-20 ml-2">Details</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-5">
                                    <div class="flex flex-col lg:flex-row items-center pb-5">
                                        <div class="flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                                            <div class="sm:mr-5">
                                                <div class="w-20 h-20 image-fit">
                                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/preview-5.jpg">
                                                </div>
                                            </div>
                                            <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                                <a href="" class="font-medium text-lg">Nike Air Max 270</a>
                                                <div class="text-gray-600 mt-1 sm:mt-0">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 20</div>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">31</div>
                                                <div class="text-gray-600">Orders</div>
                                            </div>
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">76k</div>
                                                <div class="text-gray-600">Purchases</div>
                                            </div>
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">31</div>
                                                <div class="text-gray-600">Reviews</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 dark:border-dark-5 pt-5">
                                        <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 dark:border-dark-5 pb-5 sm:pb-0">
                                            <div class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium mr-3">19 August 2022</div>
                                            <div class="text-gray-600">Date of Release</div>
                                        </div>
                                        <div class="flex sm:ml-auto mt-5 sm:mt-0">
                                            <button class="btn btn-secondary w-20 ml-auto">Preview</button>
                                            <button class="btn btn-secondary w-20 ml-2">Details</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-5">
                                    <div class="flex flex-col lg:flex-row items-center pb-5">
                                        <div class="flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                                            <div class="sm:mr-5">
                                                <div class="w-20 h-20 image-fit">
                                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/preview-15.jpg">
                                                </div>
                                            </div>
                                            <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                                <a href="" class="font-medium text-lg">Apple MacBook Pro 13</a>
                                                <div class="text-gray-600 mt-1 sm:mt-0">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomi</div>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">217</div>
                                                <div class="text-gray-600">Orders</div>
                                            </div>
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">52k</div>
                                                <div class="text-gray-600">Purchases</div>
                                            </div>
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">217</div>
                                                <div class="text-gray-600">Reviews</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 dark:border-dark-5 pt-5">
                                        <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 dark:border-dark-5 pb-5 sm:pb-0">
                                            <div class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium mr-3">4 September 2022</div>
                                            <div class="text-gray-600">Date of Release</div>
                                        </div>
                                        <div class="flex sm:ml-auto mt-5 sm:mt-0">
                                            <button class="btn btn-secondary w-20 ml-auto">Preview</button>
                                            <button class="btn btn-secondary w-20 ml-2">Details</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-5">
                                    <div class="flex flex-col lg:flex-row items-center pb-5">
                                        <div class="flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                                            <div class="sm:mr-5">
                                                <div class="w-20 h-20 image-fit">
                                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/preview-6.jpg">
                                                </div>
                                            </div>
                                            <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                                <a href="" class="font-medium text-lg">Sony Master Series A9G</a>
                                                <div class="text-gray-600 mt-1 sm:mt-0">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomi</div>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">26</div>
                                                <div class="text-gray-600">Orders</div>
                                            </div>
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">199k</div>
                                                <div class="text-gray-600">Purchases</div>
                                            </div>
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">26</div>
                                                <div class="text-gray-600">Reviews</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 dark:border-dark-5 pt-5">
                                        <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 dark:border-dark-5 pb-5 sm:pb-0">
                                            <div class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium mr-3">6 November 2022</div>
                                            <div class="text-gray-600">Date of Release</div>
                                        </div>
                                        <div class="flex sm:ml-auto mt-5 sm:mt-0">
                                            <button class="btn btn-secondary w-20 ml-auto">Preview</button>
                                            <button class="btn btn-secondary w-20 ml-2">Details</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-5">
                                    <div class="flex flex-col lg:flex-row items-center pb-5">
                                        <div class="flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                                            <div class="sm:mr-5">
                                                <div class="w-20 h-20 image-fit">
                                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/preview-2.jpg">
                                                </div>
                                            </div>
                                            <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                                <a href="" class="font-medium text-lg">Nike Air Max 270</a>
                                                <div class="text-gray-600 mt-1 sm:mt-0">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem </div>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">59</div>
                                                <div class="text-gray-600">Orders</div>
                                            </div>
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">30k</div>
                                                <div class="text-gray-600">Purchases</div>
                                            </div>
                                            <div class="text-center rounded-md w-20 py-3">
                                                <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">59</div>
                                                <div class="text-gray-600">Reviews</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 dark:border-dark-5 pt-5">
                                        <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 dark:border-dark-5 pb-5 sm:pb-0">
                                            <div class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium mr-3">10 September 2020</div>
                                            <div class="text-gray-600">Date of Release</div>
                                        </div>
                                        <div class="flex sm:ml-auto mt-5 sm:mt-0">
                                            <button class="btn btn-secondary w-20 ml-auto">Preview</button>
                                            <button class="btn btn-secondary w-20 ml-2">Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: New Products -->
                        <!-- BEGIN: New Authors -->
                        <div class="intro-y box col-span-12">
                            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">
                                    New Authors
                                </h2>
                                <button data-carousel="new-authors" data-target="prev" class="tiny-slider-navigator btn btn-outline-secondary px-2 mr-2"> <i data-feather="chevron-left" class="w-4 h-4"></i> </button>
                                <button data-carousel="new-authors" data-target="next" class="tiny-slider-navigator btn btn-outline-secondary px-2"> <i data-feather="chevron-right" class="w-4 h-4"></i> </button>
                            </div>
                            <div id="new-authors" class="tiny-slider py-5">
                                <div class="px-5">
                                    <div class="flex flex-col lg:flex-row items-center pb-5">
                                        <div class="flex-1 flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                                            <div class="sm:mr-5">
                                                <div class="w-20 h-20 image-fit">
                                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-11.jpg">
                                                </div>
                                            </div>
                                            <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                                <a href="" class="font-medium text-lg">Al Pacino</a>
                                                <div class="text-gray-600 mt-1 sm:mt-0">Backend Engineer</div>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex flex-col justify-center items-center lg:items-start px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                                            <div class="flex items-center">
                                                <a href="" class="w-8 h-8 rounded-full flex items-center justify-center border mr-2 text-gray-500"> <i class="w-3 h-3 fill-current" data-feather="facebook"></i> </a>
                                                alpacino@left4code.com
                                            </div>
                                            <div class="flex items-center mt-2">
                                                <a href="" class="w-8 h-8 rounded-full flex items-center justify-center border mr-2 text-gray-500"> <i class="w-3 h-3 fill-current" data-feather="twitter"></i> </a>
                                                Al Pacino
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 dark:border-dark-5 pt-5">
                                        <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 dark:border-dark-5 pb-5 sm:pb-0">
                                            <div class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium mr-3">29 August 2022</div>
                                            <div class="text-gray-600">Joined Date</div>
                                        </div>
                                        <div class="flex sm:ml-auto mt-5 sm:mt-0">
                                            <button class="btn btn-secondary w-20 ml-auto">Message</button>
                                            <button class="btn btn-secondary w-20 ml-2">Profile</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-5">
                                    <div class="flex flex-col lg:flex-row items-center pb-5">
                                        <div class="flex-1 flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                                            <div class="sm:mr-5">
                                                <div class="w-20 h-20 image-fit">
                                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-14.jpg">
                                                </div>
                                            </div>
                                            <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                                <a href="" class="font-medium text-lg">Denzel Washington</a>
                                                <div class="text-gray-600 mt-1 sm:mt-0">Software Engineer</div>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex flex-col justify-center items-center lg:items-start px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                                            <div class="flex items-center">
                                                <a href="" class="w-8 h-8 rounded-full flex items-center justify-center border mr-2 text-gray-500"> <i class="w-3 h-3 fill-current" data-feather="facebook"></i> </a>
                                                denzelwashington@left4code.com
                                            </div>
                                            <div class="flex items-center mt-2">
                                                <a href="" class="w-8 h-8 rounded-full flex items-center justify-center border mr-2 text-gray-500"> <i class="w-3 h-3 fill-current" data-feather="twitter"></i> </a>
                                                Denzel Washington
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 dark:border-dark-5 pt-5">
                                        <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 dark:border-dark-5 pb-5 sm:pb-0">
                                            <div class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium mr-3">19 August 2022</div>
                                            <div class="text-gray-600">Joined Date</div>
                                        </div>
                                        <div class="flex sm:ml-auto mt-5 sm:mt-0">
                                            <button class="btn btn-secondary w-20 ml-auto">Message</button>
                                            <button class="btn btn-secondary w-20 ml-2">Profile</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-5">
                                    <div class="flex flex-col lg:flex-row items-center pb-5">
                                        <div class="flex-1 flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                                            <div class="sm:mr-5">
                                                <div class="w-20 h-20 image-fit">
                                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-11.jpg">
                                                </div>
                                            </div>
                                            <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                                <a href="" class="font-medium text-lg">Brad Pitt</a>
                                                <div class="text-gray-600 mt-1 sm:mt-0">DevOps Engineer</div>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex flex-col justify-center items-center lg:items-start px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                                            <div class="flex items-center">
                                                <a href="" class="w-8 h-8 rounded-full flex items-center justify-center border mr-2 text-gray-500"> <i class="w-3 h-3 fill-current" data-feather="facebook"></i> </a>
                                                bradpitt@left4code.com
                                            </div>
                                            <div class="flex items-center mt-2">
                                                <a href="" class="w-8 h-8 rounded-full flex items-center justify-center border mr-2 text-gray-500"> <i class="w-3 h-3 fill-current" data-feather="twitter"></i> </a>
                                                Brad Pitt
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 dark:border-dark-5 pt-5">
                                        <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 dark:border-dark-5 pb-5 sm:pb-0">
                                            <div class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium mr-3">4 September 2022</div>
                                            <div class="text-gray-600">Joined Date</div>
                                        </div>
                                        <div class="flex sm:ml-auto mt-5 sm:mt-0">
                                            <button class="btn btn-secondary w-20 ml-auto">Message</button>
                                            <button class="btn btn-secondary w-20 ml-2">Profile</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-5">
                                    <div class="flex flex-col lg:flex-row items-center pb-5">
                                        <div class="flex-1 flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                                            <div class="sm:mr-5">
                                                <div class="w-20 h-20 image-fit">
                                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-4.jpg">
                                                </div>
                                            </div>
                                            <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                                <a href="" class="font-medium text-lg">Kevin Spacey</a>
                                                <div class="text-gray-600 mt-1 sm:mt-0">Frontend Engineer</div>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex flex-col justify-center items-center lg:items-start px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                                            <div class="flex items-center">
                                                <a href="" class="w-8 h-8 rounded-full flex items-center justify-center border mr-2 text-gray-500"> <i class="w-3 h-3 fill-current" data-feather="facebook"></i> </a>
                                                kevinspacey@left4code.com
                                            </div>
                                            <div class="flex items-center mt-2">
                                                <a href="" class="w-8 h-8 rounded-full flex items-center justify-center border mr-2 text-gray-500"> <i class="w-3 h-3 fill-current" data-feather="twitter"></i> </a>
                                                Kevin Spacey
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 dark:border-dark-5 pt-5">
                                        <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 dark:border-dark-5 pb-5 sm:pb-0">
                                            <div class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium mr-3">6 November 2022</div>
                                            <div class="text-gray-600">Joined Date</div>
                                        </div>
                                        <div class="flex sm:ml-auto mt-5 sm:mt-0">
                                            <button class="btn btn-secondary w-20 ml-auto">Message</button>
                                            <button class="btn btn-secondary w-20 ml-2">Profile</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-5">
                                    <div class="flex flex-col lg:flex-row items-center pb-5">
                                        <div class="flex-1 flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                                            <div class="sm:mr-5">
                                                <div class="w-20 h-20 image-fit">
                                                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-6.jpg">
                                                </div>
                                            </div>
                                            <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                                <a href="" class="font-medium text-lg">Kevin Spacey</a>
                                                <div class="text-gray-600 mt-1 sm:mt-0">DevOps Engineer</div>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex flex-col justify-center items-center lg:items-start px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                                            <div class="flex items-center">
                                                <a href="" class="w-8 h-8 rounded-full flex items-center justify-center border mr-2 text-gray-500"> <i class="w-3 h-3 fill-current" data-feather="facebook"></i> </a>
                                                kevinspacey@left4code.com
                                            </div>
                                            <div class="flex items-center mt-2">
                                                <a href="" class="w-8 h-8 rounded-full flex items-center justify-center border mr-2 text-gray-500"> <i class="w-3 h-3 fill-current" data-feather="twitter"></i> </a>
                                                Kevin Spacey
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 dark:border-dark-5 pt-5">
                                        <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 dark:border-dark-5 pb-5 sm:pb-0">
                                            <div class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium mr-3">10 September 2020</div>
                                            <div class="text-gray-600">Joined Date</div>
                                        </div>
                                        <div class="flex sm:ml-auto mt-5 sm:mt-0">
                                            <button class="btn btn-secondary w-20 ml-auto">Message</button>
                                            <button class="btn btn-secondary w-20 ml-2">Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: New Authors -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Content -->
    </div>
    <!-- BEGIN: Dark Mode Switcher-->
    <div data-url="side-menu-light-profile-overview-2.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
        <div class="mr-4 text-gray-700 dark:text-gray-300">Dark Mode</div>
        <div class="dark-mode-switcher__toggle dark-mode-switcher__toggle--active border"></div>
    </div>
    <!-- END: Dark Mode Switcher-->
    <!-- BEGIN: JS Assets-->
</template>

<script>
export default {
name: "Main"
}
</script>

<style scoped>

</style>
