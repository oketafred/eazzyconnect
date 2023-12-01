<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    groups: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <Head title="Groups" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Groups</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="px-4 sm:px-6 lg:px-8 bg-white shadow rounded-md">
                    <!-- Header -->
                    <div class="py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 ">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 ">
                                List of Groups
                            </h2>
                        </div>
                        <div>
                            <div class="inline-flex gap-x-2">
                                <Link
                                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                   :href="route('groups.create')">
                                    Add a new Group
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
                                            Title
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Description
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="group in groups" :key="group.id">
                                        <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                            <span>{{ new Date(group.created_at).toUTCString() }}</span>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500">
                                          <span class="flex-wrap">
                                            {{ group.title}}
                                          </span>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500">
                                          <span class="flex-wrap">
                                            {{ group.description}}
                                          </span>
                                        </td>
                                        <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-center text-sm font-medium sm:pr-0">
                                            <Link :href="`/groups/${group.id}/edit`" class="text-indigo-600 hover:text-indigo-900">
                                                Edit
                                            </Link>
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

<style scoped>

</style>
