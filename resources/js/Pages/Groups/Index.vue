<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { PencilSquareIcon, PencilIcon, ClipboardDocumentListIcon } from '@heroicons/vue/24/outline'

defineProps({
    groups: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Groups" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl tracking-tight text-gray-900 leading-tight">Groups</h2>
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
                                    <tr v-for="group in groups.data" :key="group.id">
                                        <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                            <span>{{ group.createdAt }}</span>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500">
                                          <span class="flex-wrap truncate">
                                            {{ group.title}}
                                          </span>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500">
                                          <span class="flex-wrap truncate">
                                            {{ group.description}}
                                          </span>
                                        </td>
                                        <td class="flex justify-end gap-3.5 relative whitespace-nowrap py-5 text-right text-sm font-medium sm:pr-0">
                                            <Link :href="`/groups/${group.id}/show`" class="flex items-center gap-x-2.5 bg-white border border-indigo-600 text-xs text-indigo-600 py-2.5 px-4 rounded hover:bg-indigo-600 hover:text-white">
                                                <span>View Contacts</span>
                                                <ClipboardDocumentListIcon class="h-4 w-4" aria-hidden="true" />
                                            </Link>
                                            <Link :href="`/groups/${group.id}/show`" class="flex items-center gap-x-2.5 bg-white border border-indigo-600 text-xs text-indigo-600 py-2.5 px-4 rounded hover:bg-indigo-600 hover:text-white">
                                                <span>Add Contacts</span>
                                                <PencilSquareIcon class="h-4 w-4" aria-hidden="true" />
                                            </Link>
                                            <Link :href="`/groups/${group.id}/edit`" class="flex items-center gap-x-2.5 bg-white border border-green-600 text-xs text-green-600 py-2.5 px-4 rounded hover:bg-green-600 hover:text-white">
                                                <span>Edit</span>
                                                <PencilIcon class="h-4 w-4" aria-hidden="true" />
                                            </Link>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Pagination-->
                <div v-if="groups.last_page > 1">
                    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-6 sm:px-6">
                        <div>
                            <Link
                                preserve-scroll
                                v-for="link in groups.links"
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

<style scoped>

</style>
