<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
  <GuestLayout>
    <Head title="Reset Password" />

    <div class="mx-auto w-full max-w-sm lg:w-96">
      <div>
        <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
        <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">
          Register for an account
        </h2>
        <p class="mt-2 text-sm leading-6 text-gray-500">
          Already have an account?
          {{ ' ' }}
          <Link :href="route('login')" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign in here</Link>
        </p>
      </div>

      <div class="mt-10">
        <div>
          <form @submit.prevent="submit">
            <div class="mt-4">
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
                  autocomplete="new-password"
              />

              <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
              <InputLabel for="password_confirmation" value="Confirm Password" />

              <TextInput
                  id="password_confirmation"
                  type="password"
                  class="mt-1 block w-full"
                  v-model="form.password_confirmation"
                  required
                  autocomplete="new-password"
              />

              <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4">
              <PrimaryButton class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Register
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>

<!--<template>-->
<!--    <GuestLayout>-->
<!--        <Head title="Reset Password" />-->

<!--        <form @submit.prevent="submit">-->
<!--            <div>-->
<!--                <InputLabel for="email" value="Email" />-->

<!--                <TextInput-->
<!--                    id="email"-->
<!--                    type="email"-->
<!--                    class="mt-1 block w-full"-->
<!--                    v-model="form.email"-->
<!--                    required-->
<!--                    autofocus-->
<!--                    autocomplete="username"-->
<!--                />-->

<!--                <InputError class="mt-2" :message="form.errors.email" />-->
<!--            </div>-->

<!--            <div class="mt-4">-->
<!--                <InputLabel for="password" value="Password" />-->

<!--                <TextInput-->
<!--                    id="password"-->
<!--                    type="password"-->
<!--                    class="mt-1 block w-full"-->
<!--                    v-model="form.password"-->
<!--                    required-->
<!--                    autocomplete="new-password"-->
<!--                />-->

<!--                <InputError class="mt-2" :message="form.errors.password" />-->
<!--            </div>-->

<!--            <div class="mt-4">-->
<!--                <InputLabel for="password_confirmation" value="Confirm Password" />-->

<!--                <TextInput-->
<!--                    id="password_confirmation"-->
<!--                    type="password"-->
<!--                    class="mt-1 block w-full"-->
<!--                    v-model="form.password_confirmation"-->
<!--                    required-->
<!--                    autocomplete="new-password"-->
<!--                />-->

<!--                <InputError class="mt-2" :message="form.errors.password_confirmation" />-->
<!--            </div>-->

<!--            <div class="flex items-center justify-end mt-4">-->
<!--                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">-->
<!--                    Reset Password-->
<!--                </PrimaryButton>-->
<!--            </div>-->
<!--        </form>-->
<!--    </GuestLayout>-->
<!--</template>-->
