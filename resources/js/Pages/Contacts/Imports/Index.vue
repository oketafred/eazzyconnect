<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { group } = defineProps({
    contactCount: Number,
    group: Object
});

const form =  useForm({
    group_id: group.id,
    file: null
});

const formattedErrorString = (error) => {
    return error
        .replace('The phone_number', '')
        .replace('.', '');
}

let submit = () => {
    form.post(route('contact-import.store', group.id));
}
</script>

<template>
    <Head title="Create Group" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl tracking-tight text-gray-900 leading-tight">
                {{ group.title }}
            </h2>
        </template>

        <!--Error Here-->
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.flash.import_error" class="rounded-md bg-red-200 p-4 mt-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <template v-for="error in JSON.parse($page.props.flash.import_error)">
                                <h3 class="text-sm font-medium text-red-800">
                                    {{ error.values.phone_number }}
                                    {{ formattedErrorString(error.errors[0]) }} at row {{ error.row }}
                                </h3>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/Error Here-->

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between bg-white shadow rounded-md">
                    <div class="px-4 sm:px-6 lg:px-8 py-6">
                        <h2 class="text-xl font-bold mb-6">{{ contactCount }} Contacts Available</h2>
                        <p>{{ group.description}}</p>
                    </div>
                    <div class="px-4 sm:px-6 lg:px-8 py-6">
                        <div class="flex gap-3 mt-5">
                            <a href="/contact/download-template" download class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Download Template</a>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center bg-white mt-8 shadow rounded-md">
                    <div class="px-4 sm:px-6 lg:px-8 py-6">
                        <form @submit.prevent="submit">
                            <input
                                type="file"
                                name="file"
                                @input="form.file = $event.target.files[0]"
                                accept="text/csv"
                                required
                            />
                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                            </progress>
                            <button
                                :disabled="form.processing"
                                type="submit"
                                class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                {{ form.processing ? '...Loading' : 'Submit' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
