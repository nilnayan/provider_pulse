<script setup>
import { router } from "@inertiajs/vue3";
import { ref, watch } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import throttle from "lodash/throttle";
import { PencilSquareIcon, MagnifyingGlassIcon, PlusIcon, TrashIcon } from "@heroicons/vue/24/outline";
import moment from "moment";
import MainLayout from "@/Layouts/MainLayout.vue";
import Pagination from "@/Components/Pulse/Pagination.vue";
import Modal from "@/Components/Pulse/Modal.vue";

const showModal = ref(false);

const editNote = (id) => {
    const url = '/users/' + props.user.id + '/notes/' + id;
    axios.get(url).then(res => {
        userNote.value = res.data;
        showModal.value = true;
    })
}

const storeNote = () => {
    const url = '/users/' + props.user.id + '/notes/';
    // alert(url);
    router.post(url, {
            'title': userNote.value.title,
            'content': userNote.value.content,
        },
        {
            preserveState: true,
            preserveScroll: true,
        });
}

const updateNote = (id) => {
    const url = '/users/' + props.user.id + '/notes/' + id;
    router.put(url, {
        'title': userNote.value.title,
        'content': userNote.value.content,
        },
        {
            preserveState: true,
            preserveScroll: true,
        });
}

const handleAction = (msg) => {
    if (msg === 'save') {
        if (userNote.value.id)
            updateNote(userNote.value.id);
        else
            storeNote();
    }

    userNote.value = { title: null, content: null };
    showDialog.value = false;
}

// let userNoteId = ref(null);

let props = defineProps({
    user: Object,
    user_notes: Object,
    filters: Object,
});

let searchTerm = ref(props.filters.search_term);
let userNote = ref({
    title: null,
    content: null,
});

watch(searchTerm, throttle(function(value) {
    const url = '/users/' + props.user.id + '/notes/';
    router.get(url, { search_term: value }, {
        preserveState: true,
        replace: true,
    });
}, 500));

</script>

<template>
    <Head title="User Notes" />

    <MainLayout>
        <template #header>User Notes for {{ user.first_name }} {{ user.last_name }}</template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-end my-2">
                        <div>
                            <label for="search_term" class="sr-only">Search</label>
                            <input type="text" v-model="searchTerm" name="search_term" id="search_term" placeholder="Search Notes..." class="w-96 block rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
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
                            <th scope="col" class="py-3.5 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Note</th>
                            <th scope="col" class="py-3.5 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3"></th>
                            <th scope="col" class="py-3.5 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="note in user_notes.data" :key="user_notes.id">
                            <td class="align-top whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ moment(note.created_at).format('MM/DD/YYYY') }}</td>
                            <td class="align-top whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ moment(note.updated_at).format('MM/DD/YYYY') }}</td>
                            <td class="align-top px-3 py-4 text-sm text-gray-500">
                                <h3 class="font-semibold text-lg mb-2">{{ note.title }}</h3>
                                <div>
                                    {{ note.content }}
                                </div>
                            </td>
                            <td class="align-top whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                            </td>
                            <td class="align-top whitespace-nowrap px-3 py-5 text-sm text-gray-500 flex justify-end">
                                <PencilSquareIcon @click="editNote(note.id)" class="-mr-0.5 h-4 w-4 mt-1" aria-hidden="true" />
                                <Link method="delete" :href="'/users/' + props.user.id + '/notes/' + note.id"><TrashIcon class="-mr-0.5 h-4 w-4 ml-2 mt-1" aria-hidden="true" /></Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <Pagination :links="user_notes.links" />
                </div>
            </div>
        </div>
        <Modal :open="showModal" @close="showModal = false" id="modal">
            <template #icon><PencilSquareIcon class="h-6 w-6 text-slate-600" aria-hidden="true" /></template>
            <template #title>Edit Note</template>
            <div class="gap-x-6 w-full">
                <div class="sm:w-full">
                    <label for="title" class="block mt-5 text-sm font-medium leading-6 text-gray-900">Title</label>
                    <div class="mt-2">
                        <div class="flex sm:max-w-md">
                            <input type="text" name="title" v-model="userNote.title" id="title" class="block sm:w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Note Title" />
                        </div>
                    </div>
                </div>

                <div class="col-span-full mt-5">
                    <label for="content" class="block text-sm font-medium leading-6 text-gray-900">Content</label>
                    <div class="mt-2">
                        <textarea rows="3" name="content" v-model="userNote.content" id="content" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                    </div>
                    <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about a topic.</p>
                </div>
            </div>
        </Modal>
    </MainLayout>
</template>
