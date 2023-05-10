<script setup>
import { router } from "@inertiajs/vue3";
import { ref, watch } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import throttle from "lodash/throttle";
import { EyeIcon, MagnifyingGlassIcon, PlusIcon, TrashIcon } from "@heroicons/vue/24/outline";
import MainLayout from "@/Layouts/MainLayout.vue";
import Pagination from "@/Components/Pulse/Pagination.vue";

const allSelected = ref(false);
const selected = ref([]);

let props = defineProps({
    users: Object,
    filters: Object,
});

let searchTerm = ref(props.filters.search_term);

watch(searchTerm, value => {
    // throttle(() => {
    router.get('/users', { search_term: value }, {
        preserveState: true,
        replace: true,
    })
    // }, 500)
});

function selectAll() {
    selected.value = [];
    if (allSelected.value === true)
        return;

    props.users.data.forEach((user) => {
        selected.value.push(user.id);
    });
}

function updateCheckAll() {
    allSelected.value = selected.value.length === props.users.data.length;
};

</script>

<template>
    <Head title="Users" />

    <MainLayout>
        <template #header>Users</template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-end my-2">
                        <div>
                            <label for="search_term" class="sr-only">Search</label>
                            <input type="text" v-model="searchTerm" name="search_term" id="search_term" placeholder="Search Users..." class="w-96 block rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                        <Link href="/users/create" type="button" title="Create New User" class="inline-flex items-center gap-x-2 rounded-md bg-green-700 ml-3 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <PlusIcon class="-mr-0.5 h-5 w-5" aria-hidden="true" />
                        </Link>
                        <button type="button" title="Delete Selected" class="inline-flex items-center gap-x-2 rounded-md bg-red-500 ml-2 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <TrashIcon class="-mr-0.5 h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>
                    <table class="min-w-full divide-y divide-gray-300 w-full">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Department</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-right">Job Title</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-2 sm:pr-4 flex justify-end">
                                <span class="sr-only">Edit</span>
                                <input type="checkbox" v-model="allSelected" @click="selectAll" class="ml-2" />
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="user in users.data" :key="user.id">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ user.first_name }} {{ user.last_name }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ user.email }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ user.phone }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                {{ user.department ? user.department.name : null }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right">
                                {{ user.job_title ? user.job_title.name : null }}
                            </td>
                            <td class="align-top py-4 pl-4 text-xs text-right font-medium sm:pl-0 flex pr-2 sm:pr-4 justify-end">
                                <Link :href="'/users/' + user.id + '/edit'"><EyeIcon class="h-4 w-4 ml-2" /></Link>
                                <input type="checkbox" :value="user.id" v-model="selected" @change="updateCheckAll" class="ml-2"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <Pagination :links="users.links" />
                </div>
            </div>
        </div>

    </MainLayout>
</template>
