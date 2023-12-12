<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    smses: { type: Object, required: true },
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl tracking-tight text-gray-900 leading-tight">SMS Consumption Report</h2>
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
                                            Receiver
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Group
                                        </th>
                                        <th scope="col"
                                            class="whitespace-nowrap px-3 py-3.5 text-center text-sm font-semibold text-gray-900">
                                            Cost (UGX)
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Status
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="sms in smses.data" :key="sms.id">
                                        <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                            <span>{{ sms.createdAt }}</span>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500">
                                          <span class="flex-wrap">
                                            {{ sms.message }}
                                          </span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-5 text-gray-500 text-sm">
                                            {{ sms.phoneNumber }}
                                        </td>
                                        <td class="whitespace-nowrap font-bold px-3 py-5 text-gray-500 text-sm">
                                            {{ sms.groupTitle }}
                                        </td>
                                        <td class="whitespace-nowrap text-center px-3 py-5 text-gray-500 text-sm">
                                            {{ sms.cost }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-5 text-gray-500">
                                          <span
                                              class="inline-flex items-center rounded-md px-2 py-1 text-xs text-white ring-1 ring-inset ring-green-600/20"
                                              :class="{ 'bg-green-500': sms.status === 'Success', 'bg-red-500': sms.status !== 'Success' }"
                                          >
                                            {{ sms.status }}
                                          </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Pagination-->
                <div v-if="smses.last_page > 1">
                    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-6 sm:px-6">
                        <div>
                            <Link
                                preserve-scroll
                                v-for="link in smses.links"
                                :href="link.url ?? ''"
                                v-html="link.label"
                                :class="link.active ? 'relative z-10 inline-flex items-center bg-blue-500 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500': 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0'"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
