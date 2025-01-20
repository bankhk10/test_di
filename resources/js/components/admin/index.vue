<script setup>
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
} from "@headlessui/vue";
import { Bars3Icon, BellIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'
import { FwbPagination } from 'flowbite-vue'
import { ref } from 'vue'

const currentPage = ref(1)

const user = {
    name: "Tom Cook",
    email: "tom@example.com",
    imageUrl:
        "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
};
const navigation = [
    { name: "Users", href: "/admin", current: true },
    { name: "Dashboard", href: "#", current: false },

];
const userNavigation = [
    { name: "Your Profile", href: "#" },
    { name: "Settings", href: "#" },
    { name: "Sign out", href: "#" },
];

const imageCard = "/img/logoVbeyond-bg.png";


const users = [
    {
        name: "Bonnie Green",
        jobTitle: "Visual Designer",
        imageCard: imageCard,
    },
    {
        name: "John Doe",
        jobTitle: "Software Engineer",
        imageCard: imageCard,
    },
    {
        name: "Jane Smith",
        jobTitle: "Product Manager",
        imageCard: imageCard,
    },
    {
        name: "Jane Smith",
        jobTitle: "Product Manager",
        imageCard: imageCard,
    },
    {
        name: "Jane Smith",
        jobTitle: "Product Manager",
        imageCard: imageCard,
    },
    {
        name: "Jane Smith",
        jobTitle: "Product Manager",
        imageCard: imageCard,
    },
    {
        name: "Jane Smith",
        jobTitle: "Product Manager",
        imageCard: imageCard,
    },
    {
        name: "Jane Smith",
        jobTitle: "Product Manager",
        imageCard: imageCard,
    },

];

</script>

<template>
    <div class="min-h-full">
        <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
            <div class="mx-auto lg:px-12">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <img class="size-12" :src="imageCard" alt="Your Company" />
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[
                                    item.current
                                        ? 'bg-gray-900 text-white'
                                        : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                                    'rounded-md px-3 py-2 font-medium',
                                ]" :aria-current="item.current ? 'page' : undefined
                                    ">{{ item.name }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <!-- Profile dropdown -->
                            <Menu as="div" class="relative ml-3">
                                <div>
                                    <MenuButton
                                        class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                        <span class="absolute -inset-1.5" />
                                        <span class="sr-only">Open user menu</span>
                                        <img class="size-8 rounded-full" :src="user.imageUrl" alt="" />
                                    </MenuButton>
                                </div>
                                <transition enter-active-class="transition ease-out duration-100"
                                    enter-from-class="transform opacity-0 scale-95"
                                    enter-to-class="transform opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-none">
                                        <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                        <a :href="item.href" :class="[
                                            active
                                                ? 'bg-gray-100 outline-none'
                                                : '',
                                            'block px-4 py-2 text-sm text-gray-700',
                                        ]">{{ item.name }}</a>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <DisclosureButton
                            class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="absolute -inset-0.5" />
                            <span class="sr-only">Open main menu</span>
                            <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true" />
                            <XMarkIcon v-else class="block size-6" aria-hidden="true" />
                        </DisclosureButton>
                    </div>
                </div>
            </div>

            <DisclosurePanel class="md:hidden">
                <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                    <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[
                        item.current
                            ? 'bg-gray-900 text-white'
                            : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                        'block rounded-md px-3 py-2 text-base font-medium',
                    ]" :aria-current="item.current ? 'page' : undefined">{{ item.name }}
                    </DisclosureButton>
                </div>
                <div class="border-t border-gray-700 pb-3 pt-4">
                    <div class="flex items-center px-5">
                        <div class="shrink-0">
                            <img class="size-10 rounded-full" :src="user.imageUrl" alt="" />
                        </div>
                        <div class="ml-3">
                            <div class="text-base/5 font-medium text-white">
                                {{ user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-400">
                                {{ user.email }}
                            </div>
                        </div>
                        <button type="button"
                            class="relative ml-auto shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="absolute -inset-1.5" />
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="size-6" aria-hidden="true" />
                        </button>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">
                            {{ item.name }}
                        </DisclosureButton>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>

        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="font-serif text-3xl tracking-tight text-sky-900 text-center">
                    ข้อมูลพนักงาน
                </h1>
            </div>
        </header>

        <main>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 py-6">
                <div v-for="user in users" :key="user.name"
                    class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex flex-col items-center pb-10 bg-gray-800 rounded-md">
                        <img class="w-24 h-24 mb-3 rounded-full shadow-lg mt-8" :src="user.imageCard"
                            :alt="user.name" />
                        <h5 class="mb-1 text-xl font-medium text-stone-50 dark:text-white">
                            {{ user.name }}
                        </h5>
                        <span class="text-sm text-gray-400 dark:text-gray-400">
                            {{ user.jobTitle }}
                        </span>
                        <div class="flex mt-4 md:mt-6">
                            <a href="/admin/detail"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Detail
                            </a>
                            <a href="#"
                                class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 focus:z-10 focus:ring-4  hover:bg-slate-200">
                                Log
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
