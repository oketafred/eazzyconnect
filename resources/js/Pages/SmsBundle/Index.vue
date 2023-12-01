<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue'

const props = defineProps({
    group_count: Number
})

const smsBundles = ref([
  {
    id: 1,
    date: 'December 1, 2023 12:06 AM',
    amount: '9,000',
    numberOfSms: 300,
    paymentMethod: 'Mobile Money',
    status: 'Success',
    referenceNumber: 'WCSWWEBEWWW'
  },
  {
      id: 2,
      date: 'December 1, 2023 12:06 AM',
      amount: '15,000',
      numberOfSms: 500,
      paymentMethod: 'Mobile Money',
      status: 'Success',
      referenceNumber: 'WCSWWEBEWWW'
  }
]);

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">SMS Bundle</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="px-4 sm:px-6 lg:px-8 bg-white shadow py-6 rounded-md">
                <h2>SMS Bundle pricing coming here</h2>
              </div>

              <!-- Table -->
              <div class="px-4 sm:px-6 lg:px-8 bg-white shadow rounded-md mt-8">
                <!-- Header -->
                <div class="py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 ">
                  <div>
                    <h2 class="text-xl font-semibold text-gray-800 ">
                      SMS Bundle Topups
                    </h2>
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
                                Number of SMSes
                            </th>
                          <th scope="col"
                              class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">
                            Amount (UGX)
                          </th>
                          <th scope="col"
                              class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">
                            Payment Method
                          </th>
                        <th scope="col"
                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Phone Number
                        </th>
                          <th scope="col"
                              class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Status
                          </th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Reference Number
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                          <tr v-for="smsBundle in smsBundles" :key="smsBundle.id">
                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                              <span>{{ smsBundle.date }}</span>
                            </td>
                            <td class="whitespace-nowrap text-center py-5 pl-4 pr-3 text-sm sm:pl-0">
                              <span>{{ smsBundle.numberOfSms }}</span>
                            </td>
                              <td class="whitespace-nowrap text-right py-5 pl-4 pr-3 text-sm sm:pl-0">
                                  <span>{{ smsBundle.amount }}</span>
                              </td>
                            <td class="whitespace-nowrap text-center py-5 pl-4 pr-3 text-sm sm:pl-0">
                              <span>{{ smsBundle.paymentMethod }}</span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-gray-500 text-sm">+256751591628</td>
                            <td class="whitespace-nowrap px-3 py-5 text-gray-500">
                              <span
                                class="inline-flex items-center rounded-md bg-green-500 px-2 py-1 text-xs text-white ring-1 ring-inset ring-green-600/20">
                                Success
                              </span>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500">
                              <span class="flex-wrap">
                                {{ smsBundle.referenceNumber }}
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
