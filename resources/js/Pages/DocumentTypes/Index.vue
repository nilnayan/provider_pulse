<template>
    <Head title="Document Types" />
    <MainLayout>
        <template #header>Document Types</template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-5 py-6">
                    <div class="flex justify-end my-2">
                        <button type="button" @click="createDocumentType" title="Create new document type" class="inline-flex items-center gap-x-2 rounded-md bg-indigo-500 ml-3 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <PlusIcon class="-mr-0.5 h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>
                    <table class="min-w-full divide-y divide-gray-300 w-full">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Allowed Formats</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-right">Updated</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-2 sm:pr-4 flex justify-end">
                                <span class="sr-only">View</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="document_type in document_types" :key="document_type.id">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ document_type.name }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ document_type.description }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ document_type.allowed_formats }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right">
                                {{ new Date(Date.parse(document_type.updated_at)).toLocaleString() }}
                            </td>
                            <td class="align-top py-4 pl-4 text-xs text-right font-medium sm:pl-0 flex pr-2 sm:pr-4 justify-end">
                                <PencilSquareIcon @click="editDocumentType(document_type.id)" class="-mr-0.5 h-4 w-4 mt-1" aria-hidden="true" />
                                <Link :href="'/document-types/' + document_type.id" method="delete" class="ml-2">
                                    <TrashIcon class="-mr-0.5 h-4 w-4 mt-1" aria-hidden="true" />
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Modal :open="showModal" @close="showModal = false" @save="saveDocumentType" id="modal">
            <template #icon><PencilSquareIcon class="h-6 w-6 text-slate-600" aria-hidden="true" /></template>
            <template #title>Edit DocumentType</template>
            <div class="gap-x-6 w-full">
                <div class="sm:w-full">
                    <label for="title" class="block mt-5 text-sm font-medium leading-6 text-gray-900">Name</label>
                    <div class="mt-2">
                        <div class="flex sm:max-w-md">
                            <input type="text" name="name" v-model="curDocumentType.name" id="name" class="block sm:w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="DocumentType name" />
                        </div>
                    </div>
                </div>
                <div class="col-span-full mt-5">
                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                    <div class="mt-2">
                        <textarea rows="3" name="description" v-model="curDocumentType.description" id="description" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                    </div>
                    <p class="mt-3 text-sm leading-6 text-gray-600">Describe the document type.</p>
                </div>
                <div class="sm:w-full">
                    <label for="allowed_formats" class="block mt-5 text-sm font-medium leading-6 text-gray-900">Allowed Formats</label>
                    <div class="mt-2">
                        <div class="flex sm:max-w-md">
                            <input type="text" name="allowed_formats" v-model="curDocumentType.allowed_formats" id="allowed_formats" class="block sm:w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="pdf,txt,etc" />
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
    </MainLayout>
</template>

<script setup>
import { router, Head, Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import { PencilSquareIcon, PlusIcon, TrashIcon } from "@heroicons/vue/24/outline";
import Modal from "@/Components/Pulse/Modal.vue";
import {ref} from "vue";

const showModal = ref(false);

const createDocumentType = () => {
    curDocumentType.value = {
        id: null,
        name: null,
        description: null,
        allowed_formats: null,
    };

    showModal.value = true;
}

const editDocumentType = (id) => {
    const url = '/document-types/' + id;
    axios.get(url).then(res => {
        curDocumentType.value = res.data;
        showModal.value = true;
    })
}

const storeDocumentType = () => {
    const url = '/document-types/';
    router.post(url, {
            'name': curDocumentType.value.name,
            'description': curDocumentType.value.description,
            'allowed_formats': curDocumentType.value.allowed_formats,
        },
        {
            preserveState: true,
            preserveScroll: true,
        });
}

const updateDocumentType = (id) => {
    const url = '/document-types/' + id;
    router.put(url, {
            'name': curDocumentType.value.name,
            'description': curDocumentType.value.description,
            'allowed_formats': curDocumentType.value.allowed_formats,
        },
        {
            preserveState: true,
            preserveScroll: true,
        });
}

const saveDocumentType = () => {
    if (curDocumentType.value.id)
        updateDocumentType(curDocumentType.value.id);
    else
        storeDocumentType();

    curDocumentType.value = { id: null, name: null };
    showModal.value = false;
}

let curDocumentType = ref({
    id: null,
    name: null,
    description: null,
    allowed_formats: null,
})

let props = defineProps({
    document_types: Object,
})
</script>

<style scoped>

</style>
