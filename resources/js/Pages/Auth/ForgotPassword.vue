<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
  <GuestLayout>
    <Head title="Forgot Password" />

    <div class="mx-auto w-full max-w-sm lg:w-96">
      <div>
        <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
        <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Forgot password?</h2>
        <p class="mt-2 text-sm leading-6 text-gray-500">
          Remember your password?
          {{ ' ' }}
          <Link
            :href="route('login')"
            class="font-semibold text-indigo-600 hover:text-indigo-500">
            Sign in here
          </Link>
        </p>
      </div>

      <div v-if="status" class="mt-4 font-medium text-sm text-green-600">
        {{ status }}
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
              <PrimaryButton
                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                  Email Password Reset Link
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>
