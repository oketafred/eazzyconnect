<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { computed, ref, watch, watchEffect } from 'vue'

defineProps({
    errors: Object,
    groups: Array
});

const form =  useForm({
    phone_number: null,
    message: '',
    group_id: null,
    smsType: 'group',
});

const characterCount = ref(0);
const maxNumberOfCharactersPerSms = 160;

watch(() => form.message, (newValue, oldValue) => {
    characterCount.value = newValue.length;
});

const numberOfSms = computed(() => {
   return Math.ceil(characterCount.value / maxNumberOfCharactersPerSms);
});

watchEffect(() => {
   if (form.smsType === 'group') {
       form.phone_number = null;
       form.smsType = 'group';
   }

   if (form.smsType === 'open') {
       form.group_id = null;
       form.smsType = 'open';
   }
});

let submit = () => {
    form.post(route('sms.store'));
}
</script>

<template>
    <Head title="Send SMS" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl tracking-tight text-gray-900 leading-tight">
                Send SMS
            </h2>
        </template>

        <div class="py-12 ">
            <div class="max-w-2xl py-6 rounded-lg bg-white shadow mx-auto sm:px-6 lg:px-8">
                <form class="max-w-md mx-auto" @submit.prevent="submit">
                    <div class="py-4">
                        <fieldset class="mt-4">
                            <div class="space-y-4 sm:flex sm:items-center justify-between sm:space-x-10 sm:space-y-0">
                                <div class="flex items-center">
                                    <input id="group" value="group" v-model="form.smsType" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="group" class="ml-3 block text-sm font-medium leading-6 text-gray-900">Send Group SMS(es)</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="open" value="open" v-model="form.smsType" name="notification-method" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    <label for="open" class="ml-3 block text-sm font-medium leading-6 text-gray-900">
                                        Send SMS(es)
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="mb-6" v-if="form.smsType === 'group'">
                        <template v-if="groups">
                            <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Group</label>
                            <select v-model="form.group_id" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="null">Select group</option>
                                <option
                                    v-for="group in groups"
                                    :key="group.id"
                                    :value="group.id"
                                >
                                    {{ group.title}}
                                </option>
                            </select>
                        </template>
                        <template v-else>
                            <h4>No Group found. Click here to create a group</h4>
                        </template>
                    </div>

                    <div class="mb-6" v-if="form.smsType === 'open'">
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
