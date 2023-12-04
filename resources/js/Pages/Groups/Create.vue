<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    isOpen: Boolean,
    errors: Object
})

const form =  useForm({
    title: '',
    description: '',
});

let submit = () => {
    form.post(route('groups.store'));
}
</script>

<template>
    <Head title="Create Group" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Group
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form class="max-w-md mx-auto mt-8" @submit.prevent="submit">
                    <div class="mb-6">
                        <label
                            for="name"
                            class="block mb-2 uppercase font-bold text-xs text-gray-700">
                            Title
                        </label>
                        <input class="border border-gray-400 p-2 w-full"
                               v-model="form.title"
                               type="text"
                               name="title"
                               id="title"
                               required
                        >
                        <div v-if="form.errors.title" class="text-red-400 text-xs">
                            {{ form.errors.title }}
                        </div>
                    </div>

                    <div class="mb-6">
                        <label
                            for="email"
                            class="block mb-2 uppercase font-bold text-xs text-gray-700">
                            Description
                        </label>
                        <textarea class="border border-gray-400 p-2 w-full"
                               v-model="form.description"
                               type="text"
                               name="description"
                               id="description"
                               required
                        ></textarea>
                        <div v-if="form.errors.description" class="text-red-400 text-xs">
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <div class="mb-6">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"
                        >
                            Submit
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
