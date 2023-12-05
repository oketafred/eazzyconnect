<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue'
import { toast } from 'vue3-toastify'

const { group } = defineProps({
    contacts: Array,
    contactCount: Number,
    group: Object
});

const form =  useForm({
    phone_number: ''
});

const isOpen = ref(false);

let submit = () => {
    form.post(route('contact.store', group.id), {
        onSuccess() {
            toast.success(`Phone Number ${form.phone_number} added successfully.`)
            form.reset('phone_number');
        },
        onFinish() {
            isOpen.value = false;
        }
    });
}
</script>

<template>
    <Head title="Create Group" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ group.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between bg-white shadow rounded-md">
                    <div class="px-4 sm:px-6 lg:px-8 py-6">
                        <h2 class="text-xl font-bold mb-6">{{ contactCount }} Contacts Available</h2>
                        <p>{{ group.description}}</p>
                    </div>
                    <div class="px-4 sm:px-6 lg:px-8 py-6">
                        <div class="flex gap-3 mt-5">
                            <button
                                @click="isOpen = true"
                                type="button"
                                class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add Single Contact</button>
                            <button type="button" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Download Template</button>
                            <button type="button" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Upload CSV</button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="isOpen" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                            <form class="max-w-md mx-auto mt-8" @submit.prevent="submit">
                                <div>
                                    <div class="mt-3 sm:mt-5">
                                        <h3 class="text-base text-center font-semibold leading-6 text-gray-900" id="modal-title">Add Contact</h3>
                                        <div class="mt-2">
                                            <div class="mb-6">
                                                <label
                                                    for="name"
                                                    class="block mb-2 uppercase font-bold text-xs text-gray-700">
                                                    Phone Number
                                                </label>
                                                <input class="border border-gray-400 p-2 w-full"
                                                       v-model="form.phone_number"
                                                       type="text"
                                                       name="phone_number"
                                                       id="phone_number"
                                                       required
                                                >
                                                <div v-if="form.errors.phone_number" class="text-red-400 text-xs">
                                                    {{ form.errors.phone_number }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                    <button
                                        :disabled="form.processing"
                                        type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">Submit</button>
                                    <button @click="isOpen = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
                <!-- Table -->
                <div class="px-4 sm:px-6 lg:px-8 bg-white shadow rounded-md">
                        <!-- Header -->
                        <div class="py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 ">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 ">
                                    List of Contacts
                                </h2>
                            </div>
                            <div>
                                <div class="inline-flex gap-x-2">
                                    <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none "
                                       href="#">
                                        View all
                                    </a>
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
                                                From
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">
                                                Actions
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            <tr v-for="contact in contacts.data" :key="contact.id">
                                                <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                    <span>{{ contact.createdAt }}</span>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-gray-500 text-sm">
                                                    {{ contact.phoneNumber }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-gray-500 text-right">
                                                  <Link href="#" class="bg-white border border-indigo-600 text-indigo-600 py-1 px-2 rounded hover:bg-indigo-600 hover:text-white">
                                                    Edit
                                                  </Link>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    <!--Pagination-->
                    <div>
                        <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-6 sm:px-6">
                            <div>
                                <Link
                                    preserve-scroll
                                    v-for="link in contacts.links"
                                    :href="link.url ?? ''"
                                    v-html="link.label"
                                    :class="link.active ? 'relative z-10 inline-flex items-center bg-blue-500 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500': 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0'"
                                />
                            </div>
                          </div>
                        </div>
                    </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
