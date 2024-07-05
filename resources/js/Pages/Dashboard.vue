<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    successfulSmsCount: { type: String, required: true },
    failedSmsCount: { type: String, required: true },
    accountBalance: { type: String, required: true },
    groupCount: { type: String, required: true },
    smses: { type: Array, required: true }
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl tracking-tight text-gray-900 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              <div>
                <ul role="list" class="mt-3 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
                  <li class="col-span-1 flex rounded-md shadow-sm">
                    <div
                      class="flex w-24 h-24 flex-shrink-0 items-center justify-center bg-pink-600 rounded-l-md text-sm font-medium text-white">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                           class="w-6 h-6">
                        <path fill-rule="evenodd"
                              d="M6.912 3a3 3 0 00-2.868 2.118l-2.411 7.838a3 3 0 00-.133.882V18a3 3 0 003 3h15a3 3 0 003-3v-4.162c0-.299-.045-.596-.133-.882l-2.412-7.838A3 3 0 0017.088 3H6.912zm13.823 9.75l-2.213-7.191A1.5 1.5 0 0017.088 4.5H6.912a1.5 1.5 0 00-1.434 1.059L3.265 12.75H6.11a3 3 0 012.684 1.658l.256.513a1.5 1.5 0 001.342.829h3.218a1.5 1.5 0 001.342-.83l.256-.512a3 3 0 012.684-1.658h2.844z"
                              clip-rule="evenodd" />
                      </svg>
                    </div>
                    <div
                      class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white">
                      <div class="flex-1 truncate px-4 py-2 text-lg">
                        <Link :href="route('groups.index')" class="font-medium text-gray-900 hover:text-gray-600">Groups</Link>
                        <p class="text-gray-500">{{ groupCount }}</p>
                      </div>
                    </div>
                  </li>
                  <li class="col-span-1 flex rounded-md shadow-sm">
                    <div
                      class="flex w-24 h-24 flex-shrink-0 items-center justify-center bg-purple-600 rounded-l-md text-sm font-medium text-white">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                           class="w-6 h-6">
                        <path
                          d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                        <path
                          d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                      </svg>
                    </div>
                    <div
                      class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white">
                      <div class="flex-1 truncate px-4 py-2 text-lg">
                        <Link :href="route('sms-report.index')" class="font-medium text-gray-900 hover:text-gray-600">Delivered SMS</Link>
                        <p class="text-gray-500">{{ successfulSmsCount }}</p>
                      </div>
                    </div>
                  </li>
                  <li class="col-span-1 flex rounded-md shadow-sm">
                    <div
                      class="flex w-24 h-24 flex-shrink-0 items-center justify-center bg-yellow-500 rounded-l-md text-sm font-medium text-white">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                           class="w-6 h-6">
                        <path
                          d="M19.5 22.5a3 3 0 003-3v-8.174l-6.879 4.022 3.485 1.876a.75.75 0 01-.712 1.321l-5.683-3.06a1.5 1.5 0 00-1.422 0l-5.683 3.06a.75.75 0 01-.712-1.32l3.485-1.877L1.5 11.326V19.5a3 3 0 003 3h15z" />
                        <path
                          d="M1.5 9.589v-.745a3 3 0 011.578-2.641l7.5-4.039a3 3 0 012.844 0l7.5 4.039A3 3 0 0122.5 8.844v.745l-8.426 4.926-.652-.35a3 3 0 00-2.844 0l-.652.35L1.5 9.59z" />
                      </svg>

                    </div>
                    <div
                      class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white">
                      <div class="flex-1 truncate px-4 py-2 text-lg">
                        <Link :href="route('sms-report.index')" class="font-medium text-gray-900 hover:text-gray-600">Failed SMS</Link>
                        <p class="text-gray-500">{{ failedSmsCount }}</p>
                      </div>
                    </div>
                  </li>
                  <li class="col-span-1 flex rounded-md shadow-sm">
                    <div
                      class="flex w-24 h-24 flex-shrink-0 items-center justify-center bg-green-500 rounded-l-md text-sm font-medium text-white">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                           class="w-6 h-6">
                        <path d="M4.5 3.75a3 3 0 00-3 3v.75h21v-.75a3 3 0 00-3-3h-15z" />
                        <path fill-rule="evenodd"
                              d="M22.5 9.75h-21v7.5a3 3 0 003 3h15a3 3 0 003-3v-7.5zm-18 3.75a.75.75 0 01.75-.75h6a.75.75 0 010 1.5h-6a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z"
                              clip-rule="evenodd" />
                      </svg>

                    </div>
                    <div
                      class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white">
                      <div class="flex-1 truncate px-4 py-2 text-lg">
                        <Link :href="route('sms-bundle.index')" class="font-medium text-gray-900 hover:text-gray-600">Account Balance</Link>
                        <p class="text-gray-500">{{ accountBalance }}</p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>


              <!-- Table -->
              <div class="px-4 sm:px-6 lg:px-8 bg-white shadow rounded-md mt-12">
                <!-- Header -->
                <div class="py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 ">
                  <div>
                    <h2 class="text-xl font-semibold text-gray-800 ">
                      Recent Messages
                    </h2>
                  </div>
                  <div>
                    <div class="inline-flex gap-x-2">
                      <Link class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none "
                         :href="route('sms-report.index')">
                        View all
                      </Link>
                    </div>
                  </div>
                </div>
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
                            Status
                          </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <template v-if="smses.length">
                                  <tr v-for="sms in smses" :key="sms.id">
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
                                      <td class="whitespace-nowrap px-3 py-5 text-gray-500">

                                    <span
                                        class="inline-flex items-center rounded-md px-2 py-1 text-xs text-white ring-1 ring-inset ring-green-600/20"
                                        :class="{ 'bg-green-500': sms.status === 'Success', 'bg-red-500': sms.status !== 'Success' }"
                                    >
                                        {{ sms.status }}
                                  </span>
                                      </td>
                                  </tr>
                              </template>
                            <template v-else>
                                <tr>
                                    <td colspan="4">
                                        <div class="flex justify-center items-center">
                                            <div class="py-20 text-center text-gray-600">
                                                <div class="flex justify-center">
                                                    <XMarkIcon
                                                        class="h-12 w-12 font-bold p-2 bg-gray-400/20 rounded-full"
                                                        aria-hidden="true"
                                                    />
                                                </div>
                                                <div class="font-bold mt-3">
                                                    No Records Available
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
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
