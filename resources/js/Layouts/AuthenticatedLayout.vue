<script setup>
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';
import Logo from '../assets/logo-small.png';

import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon, UserCircleIcon } from '@heroicons/vue/24/outline'
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <div class="min-h-full">
                <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="flex h-16 items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-8 w-8" :src="Logo" alt="EazzyConnect Logo" />
<!--                                    <img class="h-8 w-8" src="" alt="EazzyConnect Logo" />-->
<!--                                    <img class="h-8 w-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" />-->
                                </div>
                                <div class="hidden md:block">
                                    <div class="ml-10 flex items-baseline space-x-4">
                                        <NavLink :href="route('dashboard')" class="rounded-md px-3 py-2 text-sm font-medium" :active="route().current('dashboard')">
                                            Dashboard
                                        </NavLink>
                                        <NavLink :href="route('groups.index')" class="rounded-md px-3 py-2 text-sm font-medium" :active="route().current('groups.index')">
                                            Groups
                                        </NavLink>
                                        <NavLink :href="route('sms-bundle.index')" class="rounded-md px-3 py-2 text-sm font-medium" :active="route().current('sms-bundle.index')">
                                            SMS Bundle
                                        </NavLink>
                                        <NavLink :href="route('sms.create')" class="rounded-md px-3 py-2 text-sm font-medium" :active="route().current('sms.create')">
                                            Send SMS
                                        </NavLink>
                                        <NavLink :href="route('sms-report.index')" class="rounded-md px-3 py-2 text-sm font-medium" :active="route().current('sms-report.index')">
                                            SMS Report
                                        </NavLink>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <div class="ml-4 flex items-center md:ml-6">
                                    <!-- Profile dropdown -->
                                    <Menu as="div" class="relative ml-3">
                                        <div>
                                            <MenuButton class="relative flex max-w-xs gap-x-4 items-center rounded-full bg-gray-800 text-sm focus:outline-none">
                                                <span class="text-gray-300">
                                                    {{ $page.props.auth.user.name }}
                                                </span>
                                                <UserCircleIcon class="block h-8 w-8 text-gray-300" aria-hidden="true" />
                                            </MenuButton>
                                        </div>
                                        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                            <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                <MenuItem v-slot="{ active }">
                                                    <Link :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']" :href="route('profile.edit')"> Profile </Link>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }">
                                                    <Link :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-left text-sm text-gray-700 w-full']" :href="route('logout')" method="post" as="button">
                                                        Log Out
                                                    </Link>
                                                </MenuItem>
                                            </MenuItems>
                                        </transition>
                                    </Menu>
                                </div>
                            </div>
                            <div class="-mr-2 flex md:hidden">
                                <!-- Mobile menu button -->
                                <DisclosureButton class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                    <span class="absolute -inset-0.5" />
                                    <span class="sr-only">Open main menu</span>
                                    <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                                    <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                                </DisclosureButton>
                            </div>
                        </div>
                    </div>

                    <DisclosurePanel class="md:hidden">
                        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                            <NavLink
                                :href="route('dashboard')"
                                class="rounded-md px-3 py-2 text-sm font-medium"
                                :class="[route().current('dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                                :active="route().current('dashboard')"
                            >
                                Dashboard
                            </NavLink>
                            <NavLink
                                :href="route('groups.index')"
                                class="rounded-md px-3 py-2 text-sm font-medium"
                                :class="[route().current('groups.index') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                                :active="route().current('groups.index')"
                            >
                                Groups
                            </NavLink>
                            <NavLink
                                :href="route('sms-bundle.index')"
                                class="rounded-md px-3 py-2 text-sm font-medium"
                                :class="[route().current('sms-bundle.index') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                                :active="route().current('sms-bundle.index')"
                            >
                                SMS Bundle
                            </NavLink>
                            <NavLink
                                :href="route('sms.create')"
                                class="rounded-md px-3 py-2 text-sm font-medium"
                                :class="[route().current('sms.create') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                                :active="route().current('sms.create')"
                            >
                                Send SMS
                            </NavLink>
                            <NavLink
                                :href="route('sms-report.index')"
                                class="rounded-md px-3 py-2 text-sm font-medium"
                                :class="[route().current('sms-report.index') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                                :active="route().current('sms-report.index')"
                            >
                                SMS Report
                            </NavLink>
                        </div>
                        <div class="border-t border-gray-700 pb-3 pt-4">
                            <div class="flex items-center px-5">
                                <div class="flex-shrink-0">
                                    <UserCircleIcon class="block h-10 w-10 text-gray-300" aria-hidden="true" />
                                </div>
                                <div class="ml-3">
                                    <div class="text-base font-medium leading-none text-white">
                                        {{ $page.props.auth.user.name }}
                                    </div>
                                    <div class="text-sm font-medium leading-none text-gray-400">
                                        {{ $page.props.auth.user.email }}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1 px-2">
                                <Link
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white"
                                    :href="route('profile.edit')"
                                >
                                    Profile
                                </Link>
                                <Link
                                    class="block rounded-md px-3 py-2 text-base font-medium text-left text-gray-400 w-full hover:bg-gray-700 hover:text-white"
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Log Out
                                </Link>
                            </div>
                        </div>
                    </DisclosurePanel>
                </Disclosure>
            </div>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div v-if="$page.props.flash.error" class="rounded-md bg-red-200 p-4 mt-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">{{ $page.props.flash.error }}</h3>
                            </div>
                        </div>
                    </div>

                    <!--Success-->
                    <div v-if="$page.props.flash.success" class="rounded-md bg-green-200 p-4 mt-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800">{{ $page.props.flash.success }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <slot />
            </main>
        </div>
    </div>
</template>
