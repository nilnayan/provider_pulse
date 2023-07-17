<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, UserCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { Link, usePage } from '@inertiajs/vue3';
import {computed, onMounted} from "vue";
import NavDropdown from "@/Components/Pulse/NavDropdown.vue";

const user = computed(() => usePage().props.auth.user);

const navigationOld = [
    { name: 'Dashboard', href: '/', current: false },
    { name: 'Users', href: '/users', current: false },
    { name: 'Document Types', href: '/document-types', current: false },
];

const navigation = [
    {
        title: 'Dashboard',
        access: 3,
        href: '/dashboard',
        current: true,
    },
    {
        title: 'Users',
        access: 3,
        href: '/users',
        current: false,
    },
    {
        title: 'Resources',
        access: 3,
        href: '/users',
        current: false,
        menu_items: [
            { name: 'Access Levels', href: '/access-levels'},
            { name: 'Departments', href: '/departments'},
            { name: 'Document Types', href: '/document-types'},
            { name: 'Employee Statuses', href: '/employee-statuses'},
            { name: 'Job Titles', href: '/job-titles'},
            { name: 'Satisfaction Levels', href: '/satisfaction-levels'},
        ]
    },
];

const userNavigation = [
    // { name: 'Settings', href: route('settings') },
    { name: 'Sign out', href: route('logout'), method: 'post' },
]
</script>

<template>
    <div class="min-h-full">
        <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Provider Pulse" />
                        </div>
                        <div class="hidden md:block">
                            <!--
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a v-for="item in navigationOld" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                            </div>
                            -->

                            <div class="ml-10 flex items-baseline space-x-4">
                                <template v-for="menu in navigation">
                                    <Link v-if="!menu.menu_items" class="text-gray-400 px-3 py-2 rounded-md  uppercase tracking-[4px] font-bold hover:text-gray-300 hover:bg-gray-700" :href="menu.href">{{ menu.title }}</Link>
                                    <NavDropdown v-if="menu.menu_items && menu.access <= 9 /*this.user.access*/" :title="menu.title">
                                        <MenuItem v-for="item in menu.menu_items" v-slot="{ active }">
                                            <a :href="item.href" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2']">
                                                {{ item.name }}</a>
                                        </MenuItem>
                                    </NavDropdown>
                                </template>
                            </div>

                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <!--
                            <button type="button" class="rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <span class="sr-only">View notifications</span>
                                <BellIcon class="h-6 w-6" aria-hidden="true" />
                            </button>
                            -->

                            <!-- Profile dropdown -->
                            <Menu as="div" class="relative ml-3">
                                <div>
                                    <MenuButton class="flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                        <span class="sr-only">Open user menu</span>
                                        <UserCircleIcon class="h-8 w-8 rounded-full text-gray-300 mt-1 focus:ring-0 focus:ring-offset-0" />
                                    </MenuButton>
                                </div>
                                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <span class="font-semibold px-4 pt-2">{{ user.name }}</span><br />
                                        <span class="text-sm font-medium px-4 pb-2 text-gray-400">{{ user.email }}</span>
                                        <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                            <Link :href="item.href" :method="item.method ?? 'get'" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</Link>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <DisclosureButton class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="sr-only">Open main menu</span>
                            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                        </DisclosureButton>
                    </div>
                </div>
            </div>

            <DisclosurePanel class="md:hidden">
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    <DisclosureButton v-for="item in navigationOld" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
                </div>
                <div class="border-t border-gray-700 pt-4 pb-3">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <!--
                            <img class="h-10 w-10 rounded-full" :src="user.imageUrl" alt="" />
                            -->
                            <UserCircleIcon class="h-8 w-8 rounded-full text-gray-300 focus:ring-0 focus:ring-offset-0" />
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">{{ user.name }}</div>
                            <div class="text-sm font-medium leading-none text-gray-400">{{ user.email }}</div>
                        </div>
                        <button type="button" class="ml-auto flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">{{ item.name }}</DisclosureButton>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>

        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                <!--
                <h1 class="text-3xl font-bold text-gray-900">{{ $page.props.title }}</h1>
                -->
                <h1 class="font-semibold text-3xl text-gray-800 leading-tight">
                    <slot name="header" />
                </h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                <!-- begin main content -->
                <slot />
                <!-- end main content -->
            </div>
        </main>
    </div>
</template>
