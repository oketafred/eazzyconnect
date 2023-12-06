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

let submit = () => {
    form.post(route('contact-import.store', group.id));
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
                            <a :href="route('contact.import')" download class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Download Template</a>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center bg-white mt-8 shadow rounded-md">
                    <div class="px-4 sm:px-6 lg:px-8 py-6">
                        <form @submit.prevent="submit">
                            <input type="file" name="file" @input="form.file = $event.target.files[0]" />
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
