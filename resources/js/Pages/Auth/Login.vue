<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div>
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
                <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Login into your account</h2>
                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Don't have an account yet?
                    {{ ' ' }}
                    <Link :href="route('register')" class="font-semibold text-indigo-600 hover:text-indigo-500">Register here</Link>
                </p>
            </div>

            <div class="mt-10">
                <div>
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="password" value="Password" />

                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                            />

                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center">
                                <label class="flex items-center">
                                    <Checkbox name="remember" v-model:checked="form.remember" />
                                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                                </label>
                            </div>

                            <div class="text-sm leading-6">
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="font-semibold text-indigo-600 hover:text-indigo-500"
                                >
                                    Forgot your password?
                                </Link>
                            </div>
                        </div>

                        <div class="mt-4">
                            <PrimaryButton class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Log in
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
