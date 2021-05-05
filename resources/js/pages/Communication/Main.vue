<template>
    <div class="flex">
        <!-- BEGIN: Content -->
        <div class="content">
            <div class="grid grid-cols-12 gap-6 mt-8">
                <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
                    <h2 class="intro-y text-lg font-medium mr-auto mt-2">
                        Inbox
                    </h2>
                    <!-- BEGIN: Inbox Menu -->
                    <div class="intro-y box bg-theme-1 p-5 mt-6">
                        <button type="button" class="btn text-gray-700 dark:text-gray-300 w-full bg-white dark:bg-theme-1 mt-1" @click.prevent="activeTab = 'report'"> <i class="w-4 h-4 mr-2" data-feather="edit-3"></i>{{$t('communication.reportError')}}</button>
                        <div class="border-t border-theme-3 dark:border-dark-5 mt-6 pt-6 text-white">
                            <a href="" class="flex items-center px-3 py-2 rounded-md cursor-pointer" :class="(activeTab === 'notifications') ? 'bg-theme-20 dark:bg-dark-1 font-medium' : ''" @click.prevent="activeTab = 'notifications'"> <i class="w-4 h-4 mr-2" data-feather="mail"></i>{{$t('global.notifications')}}</a>
                            <a class="flex items-center px-3 py-2 mt-2 rounded-md cursor-pointer" :class="(activeTab === 'teams') ? 'bg-theme-20 dark:bg-dark-1 font-medium' : ''" @click.prevent="activeTab = 'teams'" > <i class="w-4 h-4 mr-2" data-feather="star"></i>{{$t('menu.Zespoły')}}</a>
                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md cursor-pointer" :class="(activeTab === 'questions') ? 'bg-theme-20 dark:bg-dark-1 font-medium' : ''"  @click.prevent="activeTab = 'questions'"> <i class="w-4 h-4 mr-2" data-feather="inbox"></i> {{$t('communication.questions')}}</a>
                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md cursor-pointer" :class="(activeTab === 'reports') ? 'bg-theme-20 dark:bg-dark-1 font-medium' : ''" @click.prevent="activeTab = 'reports'"> <i class="w-4 h-4 mr-2" data-feather="send"></i>{{$t('communication.reports')}}</a>
                        </div>
<!--                        <div class="border-t border-theme-3 dark:border-dark-5 mt-4 pt-4 text-white">-->
<!--                            <a href="" class="flex items-center px-3 py-2 truncate">-->
<!--                                <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>-->
<!--                                Custom Work-->
<!--                            </a>-->
<!--                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md truncate">-->
<!--                                <div class="w-2 h-2 bg-theme-9 rounded-full mr-3"></div>-->
<!--                                Important Meetings-->
<!--                            </a>-->
<!--                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md truncate">-->
<!--                                <div class="w-2 h-2 bg-theme-12 rounded-full mr-3"></div>-->
<!--                                Work-->
<!--                            </a>-->
<!--                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md truncate">-->
<!--                                <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>-->
<!--                                Design-->
<!--                            </a>-->
<!--                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md truncate">-->
<!--                                <div class="w-2 h-2 bg-theme-6 rounded-full mr-3"></div>-->
<!--                                Next Week-->
<!--                            </a>-->
<!--                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md truncate"> <i class="w-4 h-4 mr-2" data-feather="plus"></i> Add New Label </a>-->
<!--                        </div>-->
                    </div>
                    <!-- END: Inbox Menu -->
                </div>
                <div class="col-span-12 lg:col-span-9 xxl:col-span-10">
                    <!-- BEGIN: Inbox Filter -->
                    <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
                        <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                            <i class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-gray-700 dark:text-gray-300" data-feather="search"></i>
                            <input type="text" class="form-control w-full sm:w-64 box px-10 text-gray-700 dark:text-gray-300 placeholder-theme-13" placeholder="Search mail">
                            <div class="inbox-filter dropdown absolute inset-y-0 mr-3 right-0 flex items-center" data-placement="bottom-start">
                                <i class="dropdown-toggle w-4 h-4 cursor-pointer text-gray-700 dark:text-gray-300" role="button" aria-expanded="false" data-feather="chevron-down"></i>
                                <div class="inbox-filter__dropdown-menu dropdown-menu pt-2">
                                    <div class="dropdown-menu__content box p-5">
                                        <div class="grid grid-cols-12 gap-4 gap-y-3">
                                            <div class="col-span-6">
                                                <label for="input-filter-1" class="form-label text-xs">From</label>
                                                <input id="input-filter-1" type="text" class="form-control flex-1" placeholder="example@gmail.com">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-2" class="form-label text-xs">To</label>
                                                <input id="input-filter-2" type="text" class="form-control flex-1" placeholder="example@gmail.com">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-3" class="form-label text-xs">Subject</label>
                                                <input id="input-filter-3" type="text" class="form-control flex-1" placeholder="Important Meeting">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-4" class="form-label text-xs">Has the Words</label>
                                                <input id="input-filter-4" type="text" class="form-control flex-1" placeholder="Job, Work, Documentation">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-5" class="form-label text-xs">Doesn't Have</label>
                                                <input id="input-filter-5" type="text" class="form-control flex-1" placeholder="Job, Work, Documentation">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-6" class="form-label text-xs">Size</label>
                                                <select id="input-filter-6" class="form-select flex-1">
                                                    <option>10</option>
                                                    <option>25</option>
                                                    <option>35</option>
                                                    <option>50</option>
                                                </select>
                                            </div>
                                            <div class="col-span-12 flex items-center mt-3">
                                                <button class="btn btn-secondary w-32 ml-auto">Create Filter</button>
                                                <button class="btn btn-primary w-32 ml-2">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full sm:w-auto flex">
                            <button class="btn btn-primary shadow-md mr-2">Start a Video Call</button>
                            <div class="dropdown">
                                <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                                </button>
                                <div class="dropdown-menu w-40">
                                    <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Contacts </a>
                                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="settings" class="w-4 h-4 mr-2"></i> Settings </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Inbox Filter -->
                    <!-- BEGIN: Inbox Content -->
                    <div class="intro-y inbox box mt-5">
                        <div class="p-5 flex flex-col-reverse sm:flex-row text-gray-600 border-b border-gray-200 dark:border-dark-1">
                            <div class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-gray-200 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                                <input class="form-check-input" type="checkbox">
                                <div class="dropdown ml-1" data-placement="bottom-start">
                                    <a class="dropdown-toggle w-5 h-5 block dark:text-gray-300" href="javascript:;" aria-expanded="false"> <i data-feather="chevron-down" class="w-5 h-5"></i> </a>
                                    <div class="dropdown-menu w-32">
                                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2"> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">All</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">None</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Read</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Unread</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Starred</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Unstarred</a> </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300"> <i class="w-4 h-4" data-feather="refresh-cw"></i> </a>
                                <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300"> <i class="w-4 h-4" data-feather="more-horizontal"></i> </a>
                            </div>
                            <div class="flex items-center sm:ml-auto">
<!--                                <div class="dark:text-gray-300">1 - 50 of 5,238</div>-->
<!--                                <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300"> <i class="w-4 h-4" data-feather="chevron-left"></i></a>-->
<!--                                <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300"> <i class="w-4 h-4" data-feather="chevron-right"></i></a>-->
<!--                                <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300"> <i class="w-4 h-4" data-feather="settings"></i></a>-->
                            </div>
                        </div>
                        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible" v-if="activeTab==='reports'">
                            <table class="table table-report -mt-2">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Plik</th>
                                    <th class="whitespace-nowrap">Tytuł</th>
                                    <th class="text-center whitespace-nowrap">Zgłoszono dnia</th>
                                    <th class="text-center whitespace-nowrap">STATUS</th>
                                    <th class="text-center whitespace-nowrap">ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="intro-x"
                                    v-for="(report, index) in reports.list"
                                    :key="'team_' + index"
                                    v-if="activeTab==='reports'"
                                >
                                    <td class="w-40">
                                        <div class="flex">
                                            <div class="w-10 h-10 image-fit zoom-in">
                                                File
<!--                                                {{report.file.original_name}}-->
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="" class="font-medium whitespace-nowrap">{{ report.title }}</a>
                                        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{report.type}}</div>
                                    </td>
                                    <td class="text-center">{{ $dayjs(report.created_at).format('DD.MM.YYYY HH:mm') }}</td>
                                    <td class="w-40">
                                        <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ report.description }} </div>
                                    </td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="javascript:" @click.prevent="$router.push({path: '/report/show/' + report.id })"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Podgląd </a>
                                            <a @click.prevent="del(report)" class="flex items-center text-theme-6" href="" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="overflow-x-auto sm:overflow-x-visible" v-if="activeTab === 'notifications'"
                             v-for="(notification, index) in notifications.list"
                             :key="'notification_' + index"
                        >
                            <div class="intro-y" >
                                <div class="inbox__item inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                                    <div class="flex px-5 py-3">
                                        <div class="w-72 flex-none flex items-center mr-5">
                                            <input class="form-check-input flex-none" type="checkbox" checked>
                                            <a href="javascript:;" class="w-5 h-5 flex-none ml-4 flex items-center justify-center text-gray-500"> <i class="w-4 h-4" data-feather="star"></i> </a>
                                            <a href="javascript:;" class="w-5 h-5 flex-none ml-2 flex items-center justify-center text-gray-500"> <i class="w-4 h-4" data-feather="bookmark"></i> </a>
                                            <div class="w-6 h-6 flex-none image-fit relative ml-5">
                                                <Avatar :src="'uploads/' + notification.data.author.avatar" :username="notification.data.author.name + ' ' + notification.data.author.lastname" size="30" color="#FFF" background-color="#930f68"/>
                                            </div>
                                            <div class="inbox__item--sender truncate ml-3">{{notification.data.author.name + ' ' + notification.data.author.lastname}}</div>
                                        </div>
                                        <div class="w-64 sm:w-auto truncate"> <span class="inbox__item--highlight">{{notification.data.message}}</span> <button v-if="notification.data.link != undefined" type="button" class="btn ml-5" @click="$router.push({path: notification.data.link})">{{$t('communication.goTo')}}</button> </div>
                                        <div class="inbox__item--time whitespace-nowrap ml-auto pl-10">{{$dayjs(notification.created_at).format('DD.MM.YYYY HH:mm')}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible" v-if="activeTab==='teams'">
                            <table class="table table-report -mt-2">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Avatar</th>
                                    <th class="whitespace-nowrap">Nazwa zespołu</th>
                                    <th class="text-center whitespace-nowrap">Założono</th>
                                    <th class="text-center whitespace-nowrap">Liczba członków</th>
                                    <th class="text-center whitespace-nowrap">ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="intro-x"
                                    v-for="(team, index) in teams.list"
                                    :key="'team_' + index" >
                                    <td class="w-40">
                                        <div class="flex">
                                            <div class="w-10 h-10 image-fit zoom-in">
                                                <Avatar :username="team.name" color="#FFF" background-color="#930f68"/>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="" class="font-medium whitespace-nowrap">{{ team.name }}</a>
                                        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">Sport &amp; Outdoor</div>
                                    </td>
                                    <td class="text-center">{{ $dayjs(team.created_at).format('DD.MM.YYYY HH:mm') }}</td>
                                    <td class="w-40">
                                        <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ team.users.length }} </div>
                                    </td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="javascript:;"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                            <a @click.prevent="$router.push({path: '/user/team/delete/' + team.id})" class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!--                        <div class="overflow-x-auto sm:overflow-x-visible" v-if="activeTab === 'teams'"-->
<!--                        >-->
<!--                                                         <div class="intro-y" >-->
<!--                                <div class="inbox__item inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">-->
<!--                                    <div class="flex px-5 py-3">-->
<!--                                        <div class="w-72 flex-none flex items-center mr-5">-->
<!--                                            <input class="form-check-input flex-none" type="checkbox" checked>-->
<!--                                            <a href="javascript:" class="w-5 h-5 flex-none ml-4 flex items-center justify-center text-gray-500"> <i class="w-4 h-4" data-feather="star"></i> </a>-->
<!--                                            <a href="javascript:" class="w-5 h-5 flex-none ml-2 flex items-center justify-center text-gray-500"> <i class="w-4 h-4" data-feather="bookmark"></i> </a>-->
<!--                                            <div class="w-6 h-6 flex-none image-fit relative ml-5">-->
<!--                                            </div>-->
<!--                                            <div class="inbox__item&#45;&#45;sender truncate ml-3"></div>-->
<!--                                        </div>-->
<!--                                        <div class="w-64 sm:w-auto truncate"> <span class="inbox__item&#45;&#45;highlight"></span> <button type="button" class="btn ml-5" >{{$t('communication.goTo')}}</button> </div>-->
<!--                                        <div class="inbox__item&#45;&#45;time whitespace-nowrap ml-auto pl-10">asdsaffa</div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            asdsadsadad-->
<!--                        </div>-->
                        <div
                            v-for="(team, index) in teams.list"
                            :key="'team_' + index"
                            class="intro-y col-span-6 xl:col-span-6 md:col-span-6 sm:col-span-12"
                            v-if="activeTab==='teams2'"
                        >
                            <div class="box">
                                <div class="flex flex-col lg:flex-row items-center p-5">
                                    <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                        <Avatar :username="team.name" color="#FFF" background-color="#930f68"/>
                                    </div>
                                    <div
                                        class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0"
                                    >
                                        <a href="" class="font-medium">{{ team.name }}</a>
                                        <div class="text-gray-600 text-xs mt-0.5">
                                            Utworzono: {{ $dayjs(team.created_at).format('DD.MM.YYYY HH:mm') }}
                                        </div>
                                        <div class="text-gray-600 text-xs mt-0.5">
                                            Członków: {{ team.users.length }}
                                        </div>
                                    </div>
                                    <div class="flex mt-4 lg:mt-0">
                                        <button class="btn btn-outline-secondary py-1 px-2" @click="showDetails[team.id] = !showDetails[team.id]">
                                            {{$t('teams.details')}}
                                        </button>
                                    </div>
                                </div>
                                <div class="flex flex-col lg:flex-row items-center p-5" v-if="showDetails[team.id] === true">
                                    <div class="intro-y box w-full">
                                        <div class="p-5">
                                            <div v-for="(member, index) in team.users" class="relative flex items-center" :key="'member_' + index">
                                                <div class="w-12 h-12 flex-none image-fit">
                                                    <Avatar :src="'uploads/' + member.avatar" :username="member.name + ' ' + member.lastname" size="40" color="#FFF" background-color="#930f68"/>
                                                </div>
                                                <div class="ml-4 mr-auto">
                                                    <a href="" class="font-medium">{{ member.name + ' ' + member.lastname }}</a>
                                                    <div class="text-gray-600 mr-5 sm:mr-5" v-if="member.companies.length != 0">
                                                        {{member.companies[0].company_name}}
                                                    </div>
                                                </div>
                                                <div class="font-medium text-gray-700 dark:text-gray-600">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-y box p-5" v-if="activeTab==='report'">
                            <div>
                                <label for="crud-form-1" class="form-label">Title</label>
                                <input id="crud-form-1"
                                       type="text"
                                       class="form-control w-full"
                                       placeholder="Input text"
                                       v-model="title"
                                >
                            </div>
                            <div class="mt-3">
                                <label for="crud-form-2" class="form-label">Czego dotyczy</label>
                                <TailSelect
                                    id="post-form-3"
                                    v-model="type"
                                    :options="{
                                     locale: 'pl',
                                     limit: 'Nie można wybrać więcej',
                                     search: false,
                                     hideSelected: false,
                                     classNames: 'w-16'
                                     }"
                                   >
                                    <option value="Wyzwanie">Wyzwanie</option>
                                    <option value="Rozwiazanie">Rozwiązanie</option>
                                    <option value="Oferta">Oferta</option>
                                    <option value="Projekt">Projekt</option>
                                    <option value="Stanowisko">Stanowisko</option>
                                    <option value="Inne">Inne</option>
                                </TailSelect>
<!--                                <input id="crud-form-2"-->
<!--                                       type="text"-->
<!--                                       class="form-control w-full"-->
<!--                                       placeholder="Input text"-->
<!--                                       v-model="type"-->
<!--                                >-->
                            </div>
                            <div class="pt-5">
                            <div
                                class="border border-gray-200 dark:border-dark-5 rounded-md p-5"
                            >
                                <div
                                    class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"
                                >
<!--                                    <div class="w-22 mr-3">-->
<!--                                        <TailSelect-->
<!--                                            id="input-wizard-2"-->
<!--                                            :options="{-->
<!--                                                locale: 'pl',-->
<!--                                                placeholder: 'Wybierz...',-->
<!--                                                limit: 'Nie można wybrać więcej',-->
<!--                                                search: false,-->
<!--                                                hideSelected: false,-->
<!--                                                classNames: 'w-full'-->
<!--                                            }"-->
<!--                                        >-->
<!--                                            <option value="pl">PL</option>-->
<!--                                            <option value="en">ENG</option>-->

<!--                                        </TailSelect>-->
<!--                                    </div>-->
                                    {{$t('challengesNew.description')}}
                                </div>
                                <div class="mt-5">
                                    <textarea v-model="description" style="width: 100%;"></textarea>
                                </div>
                            </div>
                            </div>
                            <div
                                class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5"
                            >
                                <div class="mt-5">
                                    <div class="mt-3">
                                        <label class="form-label"> {{ $t('challengesNew.file') }}</label>
                                        <div
                                            class="rounded-md pt-4"
                                        >
                                            <div class="flex flex-wrap px-4">
                                                <Dropzone
                                                    style="position: relative; display: flex;"
                                                    ref-key="dropzoneSingleRef"
                                                    :options="{
                                                     url: '/api/report/files/store',
                                                     thumbnailWidth: 150,
                                                     maxFilesize: 5,
                                                     maxFiles: 5,
                                                     previewTemplate: '<div style=\'display: none\'></div>'
                                                    }"
                                                    class="dropzone">
                                                    <div
                                                        class="px-4 py-4 flex items-center cursor-pointer relative"
                                                    >
                                                        <ImageIcon class="w-4 h-4 mr-2"/>
                                                        <span class="text-theme-1 dark:text-theme-10 mr-1"
                                                        >{{$t('challengesNew.file')}}</span
                                                        >
                                                        {{ $t('challengesNew.fileUpload')}}
                                                    </div>
                                                </Dropzone>
                                            </div>

                                         </div>

                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer text-right">
                                <button type="button" class="btn btn-primary w-20" @click="saveReportRepo">Send</button>
                            </div>
                        </div>
                        <!--                        <div class="p-5 flex flex-col sm:flex-row items-center text-center sm:text-left text-gray-600">-->
<!--                            asdsadsadsa-->
<!--                        </div>-->
                    </div>
                    <!-- END: Inbox Content -->
                </div>
            </div>
        </div>

       <!-- END: Content -->
    </div>
    <Modal :show="show" @closed="modalClosed">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Broadcast Message
                </h2>
                <button class="btn btn-outline-secondary hidden sm:flex"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Docs </button>
                <div class="dropdown sm:hidden">
                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-600 dark:text-gray-600"></i> </a>
                    <div class="dropdown-menu w-40">
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                            <a href="javascript:;" class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Docs </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-1" class="form-label">Tytuł</label>
                    <input id="modal-form-1" type="text" class="form-control" placeholder="example@gmail.com">
                </div>
                <div class="col-span-12 sm:col-span-6 pb-5">
                    <label for="modal-form-3" class="form-label">Czego dotyczy</label>
                    <input id="modal-form-3" type="text" class="form-control" placeholder="Important Meeting">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-4" class="form-label">Opis</label>
                    <input id="modal-form-4" type="text" class="form-control" placeholder="Job, Work, Documentation">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-5" class="form-label">Doesn't Have</label>
                    <input id="modal-form-5" type="text" class="form-control" placeholder="Job, Work, Documentation">
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label for="modal-form-6" class="form-label">Size</label>
                    <select id="modal-form-6" class="form-select">
                        <option>10</option>
                        <option>25</option>
                        <option>35</option>
                        <option>50</option>
                    </select>
                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer text-right">
                <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1" @click="modalClosed">Cancel</button>
                <button type="button" class="btn btn-primary w-20">Send</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
    </Modal>

</template>

<script>
import {onMounted, provide, ref, watch} from "vue";
import {GoogleMap, Marker} from 'vue3-google-map'
import cash from "cash-dom";
import GetUsers from '../../compositions/GetUsers'
import GetNotifications from '../../compositions/GetNotifications'
import GetTeams from '../../compositions/GetTeams';
import GetReports from '../../compositions/GetReports';
import SaveReport from '../../compositions/SaveReport';
import DeleteReport from '../../compositions/DeleteReport';
import Dropzone from '../../global-components/dropzone/Main'
import {useToast} from "vue-toastification";
import {useStore} from "../../store";
import Avatar from "../../components/avatar/Avatar";
import Modal from "../../components/Modal";
import SaveChallenge from "../../compositions/SaveChallenge";

const store = useStore();

export default {
    name: "Communication",
    components: {
        GoogleMap,
        Marker,
        Avatar,
        Modal,
        GetTeams,
        GetUsers,
        Dropzone,
        DeleteReport,
        GetReports
    },
    setup(props, {emit}) {
        const toast = useToast();
        const showDetails = ref([]);
        const users = ref([]);
        const user =ref({});
        const report = ref('');
        const notifications = ref([]);
        const show = ref(false);
        const showTeams = ref(false);
        const activeTab = ref('notifications');
        const teams = ref([]);
        const reports = ref([]);
        const title = ref('');
        const type = ref('');
        const description = ref('');
        const files = ref([]);
        const dropzoneSingleRef = ref();
        const report_id = ref(null);
        const file = ref({});
        const avatar_path = ref();


        watch(activeTab, (lab, prevLabel) => {
            if(lab == 'report') {
                provide("bind[dropzoneSingleRef]", el => {
                    dropzoneSingleRef.value = el;
                });
                const elDropzoneSingleRef = dropzoneSingleRef.value;
                console.log(elDropzoneSingleRef);
                elDropzoneSingleRef.dropzone.on("success", (resp) => {
                    console.log(resp.xhr.response);
                    file.value = '/uploads/' + JSON.parse(resp.xhr.response).payload;
                    toast.success('Success!');
                });
                elDropzoneSingleRef.dropzone.on("error", () => {
                    toast.error("Błąd");
                });
            }
        }, {deep: true})

        const del = async (report) => {
            axios.post('api/report/user/delete', {id: report.id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        toast.success(response.data.message);
                        console.log(report);

                    } else {
                        // toast.error(response.data.message);
                    }
                })
            await GetReportsRepositiories();
        }


        const deleteReportRepo = async () => {
              DeleteReport(report.value.id);
            await GetReportsRepositiories();
        }

        const saveReportRepo = async () => {
            await SaveReport({
                title: title.value,
                description: description.value,
                type: type.value,
                file: file.value
            });
            await GetReportsRepositiories();
        }

        const GetReportsRepositiories = async () => {
            reports.value = GetReports();
        }
        const GetUsersRepositories = async () => {
            users.value = GetUsers();
        }
        const showAddTeams = () => {
            showTeams.value = !showTeams.value;
        }
        const showAddToTeamModal = () => {
               show.value = !show.value;
            }
        const modalClosed = () => {
            show.value = false;
        }
        const GetTeamsRepositiories = async () => {
            teams.value = GetTeams();
        }
        const GetNotificationsReposistories = async() => {
            notifications.value = GetNotifications();
        }
        onMounted( () => {
            GetUsersRepositories('');
            GetNotificationsReposistories('');
            GetTeamsRepositiories('');

            GetReportsRepositiories();


            avatar_path.value = '';
            cash("body")
                .removeClass("error-page")
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })
        return {
            file,
            users,
            teams,
            user,
            showDetails,
            notifications,
            show,
            showAddToTeamModal,
            showTeams,
            showAddTeams,
            modalClosed,
            activeTab,
            saveReportRepo,
            deleteReportRepo,
            title,
            type,
            description,
            files,
            reports,
            DeleteReport,
            report_id,
            del,
            avatar_path,
            dropzoneSingleRef
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
