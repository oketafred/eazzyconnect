<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'
import Swal from 'sweetalert2'
import axios from 'axios'
import InputError from '@/Components/InputError.vue'
import MazPhoneNumberInput from 'maz-ui/components/MazPhoneNumberInput'

const props = defineProps({
    smsBundles: Object
});

const isOpen = ref(false);
const isLoading = ref(false);
const results = ref();

const form = useForm({
    amount: null,
    phone_number: null
});

onMounted(() => {
    const script = document.createElement('script');
    script.src = 'https://checkout.flutterwave.com/v3.js';
    script.async = true;
    script.onload = () => {
        window.FlutterwaveCheckout;
    };
    document.body.appendChild(script);
});

const handleSubmit = async () => {
    isLoading.value = true;
    try {
        const response = await axios.post('/sms_bundle/payment', {
            amount: form.amount,
            phone_number: form.phone_number
        });
        const payment = await response.data;

        isLoading.value = false;
        isOpen.value = false;
        makePayment(payment);
    } catch (error) {
        console.log(error);
    }
}

const verifyTransactionOnBackend = async (transactionId) => {
    try {
        const response = await axios
            .get(`/verify-transaction/${transactionId}`);
        const payment = await response.data;
    } catch (error) {
        console.log(error);
    }
}

const makePayment = (payment) => {
    FlutterwaveCheckout({
        public_key: "FLWPUBK_TEST-3ff5792905cbfdca6a7016d089688a29-X",
        tx_ref: payment.transaction_reference,
        amount: payment.amount ?? 1000,
        currency: "UGX",
        payment_options: "mobilemoneyuganda",
        customer: {
            email: payment.customer_email,
            name: payment.customer_name,
            phone_number: payment.phone_number.replace(/^\+/, ''),
        },
        customizations: {
            title: "Buy SMS Bundle",
            description: "Buy SMS Bundle",
            logo: "https://checkout.flutterwave.com/assets/img/rave-logo.png",
        },
        callback: function(payment) {
            console.log(payment);
            if(payment.status === "successful") {
                // Send AJAX verification request to backend
                verifyTransactionOnBackend(payment.transaction_id);
                Swal.fire({
                    title: 'Payment completed!',
                    text: 'Your payment has been completed successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Payment not completed!',
                    text: 'please try again.',
                });
            }
        },
        onclose: function(incomplete) {
            if (incomplete || window.verified === false) {
                Swal.fire({
                    title: 'Payment not completed!',
                    text: 'Your payment was not completed, please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
                }).then(() => {
                    window.location.reload();
                });
            }
        },
    });
}

const submit = () => {
    // send to the backend
    // send to flutterwave
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">SMS Bundle</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="flex justify-between px-4 sm:px-6 lg:px-8 bg-white shadow py-6 rounded-md">
                  <h2>SMS Bundle pricing coming here</h2>
                  <button
                      @click="isOpen = true"
                      type="button"
                      class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                      Buy SMS Bundle
                  </button>
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
                  <!--Modal-->
                  <div v-if="isOpen" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                              <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-2 sm:w-full sm:max-w-sm sm:p-6">
                                  <form class="max-w-md mx-auto mt-8" @submit.prevent="handleSubmit">
                                      <div>
                                          <div>
                                              <h3 class="text-base py-4 border-b-2 border-gray-300 text-center font-semibold leading-6 text-gray-900" id="modal-title">
                                                  Buy SMS Bundle
                                              </h3>
                                              <div>
                                                  <div class="pt-6 mb-6">
                                                      <label
                                                          for="name"
                                                          class="block mb-2 uppercase font-bold text-xs text-gray-700">
                                                          Phone Number
                                                      </label>
                                                      <MazPhoneNumberInput
                                                          required
                                                          auto-focus
                                                          no-radius
                                                          size="sm"
                                                          v-model="form.phone_number"
                                                          show-code-on-list
                                                          no-search
                                                          no-country-selector
                                                          placeholder="+256787584128"
                                                          default-country-code="UG"
                                                          @update="results = $event"
                                                          :success="results?.isValid"
                                                          :only-countries="['UG']"
                                                          autocomplete="off"
                                                      />
                                                      <span class="text-xs font-light italic">Must be a Uganda Phone number</span>
<!--                                                      <pre>{{ results }}</pre>-->
                                                      <InputError class="mt-2" :message="form.errors.phone_number" />
                                                  </div>
                                                  <div class="mb-6">
                                                      <label
                                                          for="name"
                                                          class="block mb-2 uppercase font-bold text-xs text-gray-700">
                                                          Amount
                                                      </label>

                                                      <input
                                                          v-model="form.amount"
                                                          type="number"
                                                          required
                                                          class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                      >
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                          <button
                                              type="submit"
                                              class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">
                                              {{ isLoading ? '...Loading' : 'Submit' }}
                                          </button>
                                          <button @click="isOpen = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancel</button>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!--Modal-->


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
                                class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">
                                Number of SMS(es)
                            </th>
                          <th scope="col"
                              class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">
                            Amount (UGX)
                          </th>
                          <th scope="col"
                              class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">
                            Status
                          </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                          <tr v-for="smsBundle in smsBundles.data" :key="smsBundle.id">
                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                              <span>{{ smsBundle.createdAt }}</span>
                            </td>
                            <td class="whitespace-nowrap text-center py-5 pl-4 pr-3 text-sm sm:pl-0">
                              <span>{{ smsBundle.numberOfSms }}</span>
                            </td>
                              <td class="whitespace-nowrap text-center py-5 pl-4 pr-3 text-sm sm:pl-0">
                                  <span>{{ smsBundle.amount }}</span>
                              </td>
                            <td class="whitespace-nowrap px-3 text-right py-5 text-gray-500">
                              <span
                                  :class="{
                                    'border-green-600 bg-green-100': smsBundle.status === 'Successful',
                                    'border-orange-400 bg-orange-100': smsBundle.status === 'Pending',
                                    'border-red-600 bg-red-100': smsBundle.status === 'Failed'
                                   }"
                                class="inline-flex items-center justify-center rounded-md border-[0.5px] w-20 text-black px-2 py-1 text-xs">
                                {{ smsBundle.status }}
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
