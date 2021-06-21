<template>
    <div
        class="mt-2">
        <div class="" id="fintable">
            <div class="preview">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Przed robotyzacją</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Po robotyzacji</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Zmiana</th>
                        </tr>
                        </thead>
                        <tbody v-if="challenge.financial_before != undefined">
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-1" class="form-label">
                                    Czas dostępny (min)
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="text" :value="(((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60)) / (challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60)) * 100 + '%'" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Czas produkcji (min)
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="(challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time))" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="(solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time))" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="((((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time))) - ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) / ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Produkcja  (min)
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="(challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="(solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) - ((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time))))) / ((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time))))) * 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Czas produkcji sztuk dobrych  (min)
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 ))" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round(((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) - (((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 )))) / (((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) * 100)" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    AR - Współczynnik dostepności
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="Math.round(((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time))) / (challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round(((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time))) / (solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round(((((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time))) / (solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60)) - (((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time))) / (challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60))) / (((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time))) / (solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60)) * 100)" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    PR - Współczynnik produktywności
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="Math.round(((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) / ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time))) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round(((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) / ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time))) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round(((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) / ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) - (((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) / ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time))))) / (((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) / ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * 100)" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    QR - współczynnik jakości
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="Math.round((((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 ))) / ((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) / ((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round((((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) / ((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time))))) - ((((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 ))) / ((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))))) / ((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) / ((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time))))) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    OEE
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="Math.round((((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 ))) / (challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) / (solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round((((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) / (solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60)) - ((((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 ))) / (challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60))) / ((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) / (solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60)) * 100)" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Wielkość produkcji
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="(((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 ))) * 60 / (challenge.financial_before.cycle_time)" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="(((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) * 60 / (solution.financial_after.cycle_time)" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round(((((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) * 60 / (solution.financial_after.cycle_time)) - ((((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 ))) * 60 / (challenge.financial_before.cycle_time))) / ((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) * 60 / (solution.financial_after.cycle_time))) * 100)" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    PPH na osobę na zmianę
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="(((((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 ))) * 60 / (challenge.financial_before.cycle_time))/((challenge.financial_before.days)*(challenge.financial_before.shifts)+(challenge.financial_before.weekend_shift)*50))/(challenge.financial_before.number_of_operators)" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="(((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) * 60 / (solution.financial_after.cycle_time))/((solution.financial_after.days)*(solution.financial_after.shifts)+(solution.financial_after.weekend_shift)*50))/(solution.financial_after.number_of_operators)" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round((((((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) * 60 / (solution.financial_after.cycle_time))/((solution.financial_after.days)*(solution.financial_after.shifts)+(solution.financial_after.weekend_shift)*50))/(solution.financial_after.number_of_operators)) - ((((((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 ))) * 60 / (challenge.financial_before.cycle_time))/((challenge.financial_before.days)*(challenge.financial_before.shifts)+(challenge.financial_before.weekend_shift)*50))/(challenge.financial_before.number_of_operators))) / ((((((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))) * 60 / (solution.financial_after.cycle_time))/((solution.financial_after.days)*(solution.financial_after.shifts)+(solution.financial_after.weekend_shift)*50))/(solution.financial_after.number_of_operators)) * 100)" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";

export default {
    name: "OperationalAnalysisDialog",
    props: {
      solution: Object
    },
    setup(props, context) {

        const challenge = ref({});


        onMounted(() => {
            getChallenge();
        });


        const getChallenge = () => {
            axios.post('/api/challenge/user/get/card', {id: props.solution.challenge_id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        console.log("response.data.payload");
                        console.log(response.data.payload);
                        console.log(JSON.parse(response.data.payload.save_json));
                        challenge.value = response.data.payload;
                    }
                })
        }

        return {
            challenge
        }
    }
}
</script>

<style scoped>

</style>
