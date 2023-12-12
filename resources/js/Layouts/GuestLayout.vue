<script setup>
</script>

<template>
    <div class="flex min-h-full flex-1 h-screen overflow-hidden">
        <div
            class="relative hidden w-0 flex-1 lg:block"
            style="
                background-image: url('https://images.unsplash.com/photo-1496917756835-20cb06e75b4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80');
                background-repeat: no-repeat;
                background-size: cover;
            ">
            <div class="h-full w-full bg-black/70 flex items-center justify-center">
                <div class="bg-black/40 h-60 w-96 text-gray-100 p-6 rounded-2xl">
                    <div class="text-2xl font-bold py-2">Contact Us</div>
                    <hr>
                    <div class="text-gray-300 my-2">
                        <span class="font-bold">Email:</span>
                        <a
                            class="text-indigo-300 pl-2.5 hover:underline"
                            href="mailto:support@eazzyconnect.com">support@eazzyconnect.com</a>
                    </div>
                    <div class="mt-6">
                        <div>SMS Pricing:</div>
                        <hr class="my-2.5">
                        <div>UGX <span class="text-xl font-bold pt-5">30</span> per SMS</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <slot />
        </div>
    </div>
</template>
