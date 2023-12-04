<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { computed, ref, watch } from 'vue'

defineProps({
    errors: Object
});

const form =  useForm({
    phone_number: '',
    message: '',
});

const characterCount = ref(0);
const maxNumberOfCharactersPerSms = 160;

watch(() => form.message, (newValue, oldValue) => {
    characterCount.value = newValue.length;
});

const numberOfSms = computed(() => {
   return Math.ceil(characterCount.value / maxNumberOfCharactersPerSms);
});

let submit = () => {
    form.post(route('sms.store'));
}
</script>

<template>
    <Head title="Send SMS" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Send SMS
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form class="max-w-md mx-auto mt-8" @submit.prevent="submit">
                    <div class="mb-6">
                        <label
                            for="name"
                            class="block mb-2 uppercase font-bold text-xs text-gray-700">
                            Phone Number(s)
                        </label>
                        <input class="border border-gray-400 p-2 w-full"
                               v-model="form.phone_number"
                               type="tel"
                               name="phone_number"
                               id="phone_number"
                               required
                        >
                        <div v-if="form.errors.phone_number" class="text-red-400 text-xs">
                            {{ form.errors.phone_number }}
                        </div>
                    </div>

                    <div class="mb-6">
                        <label
                            for="email"
                            class="block mb-2 font-bold text-xs text-gray-700">
                            <span class="uppercase">Message Body</span> <span>({{ characterCount }} Characters)</span>
                        </label>
                        <textarea class="border border-gray-400 p-2 w-full"
                               v-model="form.message"
                               name="message"
                               id="message"
                               rows="10"
                               required
                        ></textarea>
                        <template v-if="characterCount > maxNumberOfCharactersPerSms">
                            <p class="text-xs text-red-700">You have typed {{ characterCount }} characters which is equivalent to {{ numberOfSms }} SMS(es) </p>
                        </template>
                        <div v-if="form.errors.message" class="text-red-400 text-xs">
                            {{ form.errors.message }}
                        </div>
                    </div>

                    <div class="mb-6">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"
                        >
                            Send Now
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
