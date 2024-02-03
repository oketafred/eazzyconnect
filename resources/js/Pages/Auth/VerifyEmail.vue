<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue'
import Checkbox from '@/Components/Checkbox.vue'
import InputLabel from '@/Components/InputLabel.vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import TextInput from '@/Components/TextInput.vue'

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div>
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
                <h2 class="text-2xl font-bold leading-9 tracking-tight text-gray-900">Email Verification</h2>
                <div class="my-4 text-sm text-gray-600">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
                    we just emailed to you? If you didn't receive the email, we will gladly send you another.
                </div>

                <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            </div>

            <form @submit.prevent="submit">
                <div class="mt-8 flex items-center justify-between">
                    <PrimaryButton
                        class="flex rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Resend Verification Email
                    </PrimaryButton>

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="font-semibold text-red-400 underline hover:text-red-500"
                        >Log Out
                    </Link>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
