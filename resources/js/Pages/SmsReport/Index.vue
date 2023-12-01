<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue'

const props = defineProps({
    group_count: Number
})

const smses = ref([
    {
        id: 1,
        date: 'December 1, 2023 12:06 AM',
        text: 'Dear ANNET, Your Personal Use loan is in arrears by UGX 1,000. Please clear it to qualify for a higher amount next time. Kina-Kwekulakulanya Sacco',
        from: '+256751591628',
        status: 'Success'
    },
    {
        id: 2,
        date: 'December 1, 2023 12:06 AM',
        text: 'Dear Acio, Your Education loan payment of UGX 1 has been received. Thank you. Eugene Farmers Sacco\n',
        from: '+256775197747',
        status: 'Success'
    },
    {
        id: 3,
        date: 'December 1, 2023 12:06 AM',
        text: 'Dear ANNET, Your Personal Use loan is in arrears by UGX 1,000. Please clear it to qualify for a higher amount next time. Kina-Kwekulakulanya Sacco',
        from: '+256751591628',
        status: 'Success'
    },
    {
        id: 4,
        date: 'December 1, 2023 12:06 AM',
        text: 'Dear NAMBI, A deposit of UGX 2,000 to account KBT Gold Account was successful. KBT MICROFINANCE( SACCO)',
        from: '+256751591628',
        status: 'Success'
    },
    {
        id: 5,
        date: 'December 1, 2023 12:06 AM',
        text: 'Dear NABISAYI, A deposit of UGX 4,000 to account KBT Gold Account was successful. KBT MICROFINANCE( SACCO)',
        from: '+256709741885',
        status: 'Success'
    }
]);

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">SMS Consumption Report</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Table -->
                <div class="px-4 sm:px-6 lg:px-8 bg-white shadow rounded-md">
                    <!-- End Header -->
                    <div>
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                            Date</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Text
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            From
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Status
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="sms in smses" :key="sms.id">
                                        <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                            <span>December 1, 2023 12:06 AM</span>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500">
                              <span class="flex-wrap">
                                Dear ANNET, Your Personal Use loan is in arrears by UGX 1,000. Please clear it to qualify for a higher amount next time. Kina-Kwekulakulanya Sacco
                              </span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-5 text-gray-500 text-sm">+256751591628</td>
                                        <td class="whitespace-nowrap px-3 py-5 text-gray-500">
                              <span
                                  class="inline-flex items-center rounded-md bg-green-500 px-2 py-1 text-xs text-white ring-1 ring-inset ring-green-600/20">
                                Success
                              </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
