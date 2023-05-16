<script setup>
import { router } from "@inertiajs/vue3";
import { ref, watch } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import throttle from "lodash/throttle";
import { DocumentArrowUpIcon, DocumentArrowDownIcon, MagnifyingGlassIcon, PlusIcon, TrashIcon } from "@heroicons/vue/24/outline";
import moment from "moment";
import MainLayout from "@/Layouts/MainLayout.vue";
import Pagination from "@/Components/Pulse/Pagination.vue";
import Modal from "@/Components/Pulse/Modal.vue";

const form = useForm({
    user_file: '',
    description: '',
})

const handleAction = (msg) => {
    if (msg === 'save') {
        const url = '/users/' + props.user.id + '/files';
        form.post(url, {
            forceFormData: true,
        })
    }

    form.user_file = '';
    form.description = '';
    showDialog.value = false;
}

// let userFileId = ref(null);

let props = defineProps({
    user: Object,
    user_files: Object,
    filters: Object,
});

let searchTerm = ref(props.filters.search_term);
let showDialog = ref(false);

watch(searchTerm, throttle(function(value) {
    const url = '/users/' + props.user.id + '/files/';
    router.get(url, { search_term: value }, {
        preserveState: true,
        replace: true,
    });
}, 500));

</script>

<template>
    <Head title="User Files" />

    <MainLayout>
        <template #header>User Files</template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-end my-2">
                        <div>
                            <label for="search_term" class="sr-only">Search</label>
                            <input type="text" v-model="searchTerm" name="search_term" id="search_term" placeholder="Search Files..." class="w-96 block rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                        <button type="button" @click="showDialog = true" title="Create new user" class="inline-flex items-center gap-x-2 rounded-md bg-indigo-500 ml-3 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <PlusIcon class="-mr-0.5 h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>
                    <table class="min-w-full divide-y divide-gray-300 w-full">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Created</th>
                            <th scope="col" class="py-3.5 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Updated</th>
                            <th scope="col" class="py-3.5 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">File Name</th>
                            <th scope="col" class="py-3.5 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Description</th>
                            <th scope="col" class="py-3.5 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="file in user_files.data" :key="user_files.id">
                            <td class="align-top whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ moment(file.created_at).format('MM/DD/YYYY') }}</td>
                            <td class="align-top whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ moment(file.updated_at).format('MM/DD/YYYY') }}</td>
                            <td class="align-top px-3 py-4 text-sm text-gray-500">{{ file.file_name }}</td>
                            <td class="align-top px-3 py-4 text-sm text-gray-500">{{ file.description }}</td>
                            <td class="align-top whitespace-nowrap px-3 py-5 text-sm text-gray-500 flex justify-end">
                                <a :href="'/users/' + props.user.id + '/files/' + file.id"><DocumentArrowDownIcon class="-mr-0.5 h-4 w-4 ml-2 mt-1" aria-hidden="true" /></a>
                                <Link method="delete" :href="'/users/' + props.user.id + '/files/' + file.id"><TrashIcon class="-mr-0.5 h-4 w-4 ml-2 mt-1" aria-hidden="true" /></Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <Pagination :links="user_files.links" />
                </div>
            </div>
        </div>
        <Modal :open="showDialog" @response="(msg) => handleAction(msg)" id="modal">
            <template #icon><DocumentArrowUpIcon class="h-6 w-6 text-slate-600" aria-hidden="true" /></template>
            <template #title>Upload File</template>
            <div class="gap-x-6 w-full">
                <div class="sm:w-full">
                    <label for="username" class="block mt-5 text-sm font-medium leading-6 text-gray-900">File</label>
                    <div class="mt-2">
                        <div class="flex w-full">
                            <input type="file" name="image" @input="form.user_file = $event.target.files[0]" class="w-full" />
                        </div>
                    </div>
                </div>

                <div class="col-span-full mt-5">
                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                    <div class="mt-2">
                        <textarea rows="3" name="description" v-model="form.description" id="about" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                    </div>
                    <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about the file.</p>
                </div>
            </div>
        </Modal>
    </MainLayout>
</template>
