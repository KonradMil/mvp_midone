<template>
    <div class="col-span-9 lg:col-span-9 xxl:col-span-9">
<!--        <div class="intro -y flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">-->
<!--            <h2 class="font-medium text-base mr-auto">{{$t('challengesMain.myOffers')}}</h2>-->
<!--        </div>-->
        <div class="grid grid-cols-12 gap-6 md:grid-cols-12" v-if="is_offers === true">
                        <div class="intro-y box col-span-6 xxl:col-span-6">
                            <div class="intro -y flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">Oferta</h2>
                                <div class="flex items-center mr-3" v-if="project.accept_offer < 1 && stage === 3 && user.id === investor.id && activeTab !== 'oferty'"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>
                                    Oczekuje na kontroofertę ze strony integratora
                                </div>
                                <div class="flex items-center justify-center" v-if="project.accept_offer > 1 && stage === 3 && user.id === integrator.id"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>
                                    Pierwotna oferta
                                </div>
                            </div>
                             <div :class="(old_offer.status === 2) ? 'px-5 py-5 opacity-50' : 'px-5 py-5'">
                                <div id="latest-tasks-new2" class="tab-pane active" role="tabpanel" aria-labelledby="latest-tasks-new-tab">
                                    <div class="flex items-center mb-5">
                                        <div class="pl-4 my-2">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.solution')}}</span>
                                            <div class="ark:text-theme-10 text-theme-1 pt-1" style="font-size: 16px; word-break: break-all; max-height: 100px; max-width: 200px;"> {{ old_offer.solution.name }}</div>
                                        </div>
                                        <div v-if="user.id === investor.id">
            <!--                               <div class="flex items-center justify-center text-theme-6" v-if="project.accept_offer === 2 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.rejected')}}</div>-->

                                        </div>
            <!--                            <div class="" v-if="user.id === challenge_author_id && stage === 3 && new_offer.id === old_offer.id">-->
            <!--                                  <button class="btn btn-primary shadow-md mr-2" style="margin-left: 90px;" @click.prevent="acceptProjectOffer">Akceptuje</button>-->
            <!--                                  <button class="btn btn-primary shadow-md mr-2" @click.prevent="rejectProjectOffer">Odrzucam</button>-->
            <!--                            </div>-->
                                        <div class="" v-if="user.id === integrator.id && project.selected_offer_id < 1 && activeTab === 'project-offer'">
                                            <button class="btn btn-primary shadow-md ml-5" @click.prevent="editOffer(old_offer.id)">Złóż kontrofertę</button>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.offerExpires')}}:</span>
                                            <div class="text-gray-600"> {{ old_offer.offer_expires_in }} dni</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.priceDelivery')}}:</span>
                                            <div class="text-gray-600"> {{ old_offer.price_of_delivery }}zł</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.weeksToStart')}}:</span>
                                            <div class="text-gray-600"> {{ values['weeks'][old_offer.weeks_to_start] }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.timeToStart')}}:</span>
                                            <div class="text-gray-600"> {{ values['weeks-short'][old_offer.time_to_start] }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.timeToFix')}}:</span>
                                            <div class="text-gray-600"> {{ values['hours'][old_offer.time_to_fix] }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponAgreement')}}:</span>
                                            <div class="text-gray-600"> {{ values['percent'][old_offer.advance_upon_agreement] }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponDelivery')}}:</span>
                                            <div class="text-gray-600"> {{ values['percent'][old_offer.advance_upon_delivery] }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponStart')}}:</span>
                                            <div class="text-gray-600"> {{ values['percent'][old_offer.advance_upon_start] }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.yearsGuarantee')}}:</span>
                                            <div class="text-gray-600"> {{ values['years-short'][old_offer.years_of_guarantee] }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.maintenanceFrequency')}}:</span>
                                            <div class="text-gray-600"> {{ old_offer.maintenance_frequency }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.priceMaintenance')}}:</span>
                                            <div class="text-gray-600"> {{ old_offer.price_of_maintenance }}zł</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.reactionTime')}}:</span>
                                            <div class="text-gray-600"> {{ values['hours'][old_offer.reaction_time] }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.interventionPrice')}}:</span>
                                            <div class="text-gray-600"> {{ old_offer.intervention_price }}zł</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.workHourPrice')}}:</span>
                                            <div class="text-gray-600"> {{ old_offer.work_hour_price }}zł</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center mb-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.periodSupport')}}:</span>
                                            <div class="text-gray-600"> {{ old_offer.period_of_support }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            <div class="intro-y box col-span-6 xxl:col-span-6" v-if="new_offer.id !== old_offer.id && activeTab === 'project-offer' && investor.id === user.id && new_offer.is_offer_project !== 2">
                <div class="intro -y flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Kontroferta</h2>
                    <div class="flex items-center mr-3 text-theme-1" v-if="project.accept_offer === 0"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>Oczekuje na akceptacje inwestora</div>
                    <div class="flex items-center mr-3 text-theme-9" v-if="project.accept_offer === 1 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>Zaakceptowano</div>
                </div>
                <div :class="(new_offer.status === 2) ? 'px-5 py-5 opacity-50' : 'px-5 py-5'">
                    <div id="latest-tasks-two" class="tab-pane acftive" role="tabpanel" aria-labelledby="latest-tasks-new-tab">
                        <div class="flex items-center mb-5">
                            <div class="pl-4 my-2">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.solution')}}</span>
                                <div class="ark:text-theme-10 text-theme-1 pt-1" style="font-size: 16px; word-break: break-all; max-height: 100px; max-width: 200px;"> {{ new_offer.solution.name }}</div>
                            </div>
                            <div class="" v-if="user.id === challenge_author_id && challenge.stage === 3 && project.accept_offer !== 1" style="margin-left: auto;">
                                <button class="btn btn-primary shadow-md mr-2" style="margin-left: 90px;" @click.prevent="acceptProjectOffer">Akceptuję</button>
                                <button class="btn btn-primary shadow-md mr-2" @click.prevent="showModal">Odrzucam</button>
                            </div>
                        </div>
                        <div :class="(new_offer.offer_expires_in === old_offer.offer_expires_in) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.offer_expires_in === old_offer.offer_expires_in) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.offerExpires')}}:</span>
                                <div class="text-gray-600"> {{ new_offer.offer_expires_in }} dni</div>
                            </div>
                        </div>
                        <div :class="(new_offer.price_of_delivery === old_offer.price_of_delivery) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.price_of_delivery === old_offer.price_of_delivery) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.priceDelivery')}}:</span>
                                <div class="text-gray-600"> {{ new_offer.price_of_delivery }}zł</div>
                            </div>
                        </div>
                        <div :class="(new_offer.weeks_to_start === old_offer.weeks_to_start) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.weeks_to_start === old_offer.weeks_to_start) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.weeksToStart')}}:</span>
                                <div class="text-gray-600"> {{ values['weeks'][new_offer.weeks_to_start] }}</div>
                            </div>
                        </div>
                        <div :class="(new_offer.time_to_start === old_offer.time_to_start) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.time_to_start === old_offer.time_to_start) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.timeToStart')}}:</span>
                                <div class="text-gray-600"> {{ values['weeks-short'][new_offer.time_to_start] }}</div>
                            </div>
                        </div>
                        <div :class="(new_offer.time_to_fix === old_offer.time_to_fix) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.time_to_fix === old_offer.time_to_fix) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.timeToFix')}}:</span>
                                <div class="text-gray-600"> {{ values['hours'][new_offer.time_to_fix] }}</div>
                            </div>
                        </div>
                        <div :class="(new_offer.advance_upon_agreement === old_offer.advance_upon_agreement) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.advance_upon_agreement === old_offer.advance_upon_agreement) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponAgreement')}}:</span>
                                <div class="text-gray-600"> {{ values['percent'][new_offer.advance_upon_agreement] }}</div>
                            </div>
                        </div>
                        <div :class="(new_offer.adadvance_upon_delivery === old_offer.adadvance_upon_delivery) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.adadvance_upon_delivery === old_offer.adadvance_upon_delivery) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponDelivery')}}:</span>
                                <div class="text-gray-600"> {{ values['percent'][new_offer.advance_upon_delivery] }}</div>
                            </div>
                        </div>
                        <div :class="(new_offer.advance_upon_start === old_offer.advance_upon_start) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.advance_upon_start === old_offer.advance_upon_start) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponStart')}}:</span>
                                <div class="text-gray-600"> {{ values['percent'][new_offer.advance_upon_start] }}</div>
                            </div>
                        </div>
                        <div :class="(new_offer.years_of_guarantee === old_offer.years_of_guarantee) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.years_of_guarantee === old_offer.years_of_guarantee) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.yearsGuarantee')}}:</span>
                                <div class="text-gray-600"> {{ values['years-short'][new_offer.years_of_guarantee] }}</div>
                            </div>
                        </div>
                        <div :class="(new_offer.maintenance_frequency === old_offer.maintenance_frequency) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.maintenance_frequency === old_offer.maintenance_frequency) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.maintenanceFrequency')}}:</span>
                                <div class="text-gray-600"> {{ new_offer.maintenance_frequency }}</div>
                            </div>
                        </div>
                        <div :class="(new_offer.price_of_maintenance === old_offer.price_of_maintenance) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.price_of_maintenance === old_offer.price_of_maintenance) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.priceMaintenance')}}:</span>
                                <div class="text-gray-600"> {{ new_offer.price_of_maintenance }}zł</div>
                            </div>
                        </div>
                        <div :class="(new_offer.reaction_time === old_offer.reaction_time) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.reaction_time === old_offer.reaction_time) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.reactionTime')}}:</span>
                                <div class="text-gray-600"> {{ values['hours'][new_offer.reaction_time] }}</div>
                            </div>
                        </div>
                        <div :class="(new_offer.intervention_price === old_offer.intervention_price) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.intervention_price === old_offer.intervention_price) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.interventionPrice')}}:</span>
                                <div class="text-gray-600"> {{ new_offer.intervention_price }}zł</div>
                            </div>
                        </div>
                        <div :class="(new_offer.work_hour_price === old_offer.work_hour_price) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.work_hour_price === old_offer.work_hour_price) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.workHourPrice')}}:</span>
                                <div class="text-gray-600"> {{ new_offer.work_hour_price }}zł</div>
                            </div>
                        </div>
                        <div :class="(new_offer.period_of_support === old_offer.period_of_support) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div :class="(new_offer.period_of_support === old_offer.period_of_support) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.periodSupport')}}:</span>
                                <div class="text-gray-600"> {{ new_offer.period_of_support }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="intro-y box col-span-6 xxl:col-span-6" v-for="offer in offers" :key="offer.id" v-if="activeTab !== 'oferty'">
                                <div class="intro -y flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                                    <h2 class="font-medium text-base mr-auto">Kontroferta</h2>
                                    <div class="flex items-center justify-center text-theme-9" v-if="offer.is_offer_project === 1"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.accepted')}}</div>
                                    <div class="flex items-center justify-center text-theme-6" v-if="offer.is_offer_project === 2"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.rejected')}}</div>
                                    <div class="flex items-center mr-3" v-if="offer.is_offer_project < 1"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.waitingApproval')}}</div>
                                </div>
                <div :class="(offer.is_offer_project === 2) ? 'px-5 py-5 opacity-50' : 'px-5 py-5'">
                    <div id="latest-tasks-new" class="tab-pane active" role="tabpanel" aria-labelledby="latest-tasks-new-tab">
                        <div class="flex items-center">
                            <div class="pl-4 my-2">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.solution')}}</span>
                                <div class="ark:text-theme-10 text-theme-1 pt-1" style="font-size: 16px; word-break: break-all; max-height: 100px; max-width: 200px;"> {{ offer.solution.name }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.offerExpires')}}:</span>
                                <div class="text-gray-600"> {{ offer.offer_expires_in }} dni</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.priceDelivery')}}:</span>
                                <div class="text-gray-600"> {{ offer.price_of_delivery }}zł</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.weeksToStart')}}:</span>
                                <div class="text-gray-600"> {{ values['weeks'][offer.weeks_to_start] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.timeToStart')}}:</span>
                                <div class="text-gray-600"> {{ values['weeks-short'][offer.time_to_start] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.timeToFix')}}:</span>
                                <div class="text-gray-600"> {{ values['hours'][offer.time_to_fix] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponAgreement')}}:</span>
                                <div class="text-gray-600"> {{ values['percent'][offer.advance_upon_agreement] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponDelivery')}}:</span>
                                <div class="text-gray-600"> {{ values['percent'][offer.advance_upon_delivery] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponStart')}}:</span>
                                <div class="text-gray-600"> {{ values['percent'][offer.advance_upon_start] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.yearsGuarantee')}}:</span>
                                <div class="text-gray-600"> {{ values['years-short'][offer.years_of_guarantee] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.maintenanceFrequency')}}:</span>
                                <div class="text-gray-600"> {{ offer.maintenance_frequency }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.priceMaintenance')}}:</span>
                                <div class="text-gray-600"> {{ offer.price_of_maintenance }}zł</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.reactionTime')}}:</span>
                                <div class="text-gray-600"> {{ values['hours'][offer.reaction_time] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.interventionPrice')}}:</span>
                                <div class="text-gray-600"> {{ offer.intervention_price }}zł</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.workHourPrice')}}:</span>
                                <div class="text-gray-600"> {{ offer.work_hour_price }}zł</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.periodSupport')}}:</span>
                                <div class="text-gray-600"> {{ offer.period_of_support }}</div>
                            </div>
                        </div>
                        <div v-if="offer.is_offer_project === 2" class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Komentarz: </span>
                                <div class="text-gray-600" style="word-break: break-all;"> {{ offer.comment }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ModalRejectOffer :show="show" @closed="modalClosed">
        <h3 class="intro-y text-lg font-medium mt-5">Dodaj komentarz dlaczego odrzucasz ofertę!</h3>
        <div class="intro-y box p-5 mt-12 sm:mt-5" style="text-align: center;">
            <div class="relative text-gray-700 dark:text-gray-300 mr-4">
                <textarea
                    maxlength = "1000"
                    class="w-full px-3 py-2 text-gray-700 border rounded-lg border border-transparent outline-none ring-2 ring-pink-700 border-transparent"
                    style="width: 600px; height: 100px; position: relative;"
                    v-model="feedback"/>
                <div class="flex pt-2" style="margin-left: 210px;">
                    <button class="btn btn-primary shadow-md mr-2" @click.prevent="rejectProjectOffer">Odrzuć</button>
                    <button class="btn btn-primary shadow-md mr-2" @click.prevent="modalClosed">Anuluj</button>
                </div>
            </div>
        </div>
    </ModalRejectOffer>
</template>

<script>
import {getCurrentInstance, onMounted, ref, watch} from "vue";
import GetOffers from "../../../compositions/GetOffers";
import GetChallengeOffers from "../../../compositions/GetChallengeOffers";
import {useToast} from "vue-toastification";
import OfferAddProject from "./OfferAddProject";
import ModalRejectOffer from "../../../components/ModalRejectOffer";
import RequestHandler from "../../../compositions/RequestHandler";

const toast = useToast();

export default {
    name: "OfferProject",
    components :{
      OfferAddProject,
        ModalRejectOffer
    },
    props: {
        activeTab: String,
        id: Number,
        addSolutionOffer: Boolean,
        selected_offer_id: Number,
        stage: Number,
        author_id: Number,
        challenge_author_id: Number,
        project: Object,
        challenge: Object,
        integrator: Object,
        investor: Object
    },
    emits: ["update:activeTab"],

    setup(props, context) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const offers = ref([]);
        const user = window.Laravel.user;
        const values = require('../../../json/offer_values.json');
        const offer_id = ref();
        const guard = ref(false);
        const change = ref(false);
        const is_done_offer = ref(false);
        const new_offer = ref({});
        const old_offer = ref({});
        const is_offers = ref(false);
        const show = ref(false);
        const feedback = ref('');


        const modalClosed = () => {
            show.value = false;
        }

        const showModal = async() => {
            show.value = !show.value;
        }

        const switchTab = () => {
            context.emit("update:activeTab", 'addingoffer');
        }

        const editOffer = async(edit_offer_id) => {
            emitter.emit('changeToEditOffer', {edit_offer_id: edit_offer_id});
        }

        const changeOffer = async(edit_offer_id) => {
            emitter.emit('changeOfferProject', {edit_offer_id: edit_offer_id, change: change});
        }

        const noChangeOffer = async() => {
            emitter.emit('noChangeOfferProject', {is_done_offer: is_done_offer});
        }

        const getOffersProject = async(callback) => {
            RequestHandler('projects/' + props.challenge.id + '/offers', 'get', {project_id: props.project.id}, (response) => {
                if(response.data.new_offer === null){
                    new_offer.value = response.data.old_offer;
                    old_offer.value = response.data.old_offer;
                    callback(response);
                } else {
                    old_offer.value = response.data.old_offer;
                    new_offer.value = response.data.new_offer;
                    callback(response);
                }
            });
        }

        const getOffersProjectIntegrator = async(callback) => {
            RequestHandler('projects/' + props.challenge.id + '/offers/integrator', 'get', {project_id: props.project.id}, (response) => {
                    offers.value = response.data.offers;
                    old_offer.value = response.data.old_offer;
                    callback(response);
            });
        }

        const publishOffer = async(offer) => {
            axios.post('/api/offer/publish', {id: offer.id})
                .then(response => {
                    if (response.data.success) {
                        offer.status = 1;
                        toast.success('Oferta zostało opublikowane');
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        const deleteOffer = async(offer) => {
            axios.post('/api/offer/delete', {id: id})
                .then(response => {
                    if (response.data.success) {
                        toast.success(response.data.message);
                        // offers.value.splice(deadlines.value.indexOf(offer), 1);
                    } else {
                    }
                })
        }

        const acceptProjectOffer = async () => {
            RequestHandler('projects/' + props.project.id + '/offer/'+ new_offer.value.id + '/accept', 'post', {
                project_id: props.project.id,
                new_offer_id: new_offer.value.id
            }, (response) => {
                emitter.emit('acceptOffer', {});
            });
        }

        const rejectProjectOffer = async () => {
            if(feedback.value.length < 10){
                toast.warning('Komentarz musi posiadać minimum 10 znaków!')
            } else {
                RequestHandler('projects/' + props.project.id + '/offer/'+ new_offer.value.id + '/reject', 'post', {
                    project_id: props.project.id,
                    feedback: feedback.value,
                    new_offer_id: new_offer.value.id
                }, (response) => {
                    getOffersProject();
                    modalClosed();
                    emitter.emit('rejectOffer', {});
                });
            }
        }

        onMounted(() => {
            if(user.type === 'investor'){
                getOffersProject(function(){
                    is_offers.value = true;
                });
            } else {
                getOffersProjectIntegrator(function(){
                    is_offers.value = true;
                });
            }
            if(props.stage === 3){
                change.value = true;
            }
        });

        return {
            feedback,
            showModal,
            modalClosed,
            show,
            is_offers,
            new_offer,
            old_offer,
            rejectProjectOffer,
            acceptProjectOffer,
            noChangeOffer,
            is_done_offer,
            changeOffer,
            change,
            guard,
            deleteOffer,
            offer_id,
            editOffer,
            publishOffer,
            switchTab,
            offers,
            user,
            values
        }
    }
}
</script>

<style scoped>

</style>
