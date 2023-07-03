<template>
    <Head title="Departments" />
    <MainLayout>
        <template #header>Departments</template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-5 py-6">
                    <div class="flex justify-end my-2">
                        <button type="button" @click="showModal = true" title="Create new department" class="inline-flex items-center gap-x-2 rounded-md bg-indigo-500 ml-3 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <PlusIcon class="-mr-0.5 h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>
                    <table class="min-w-full divide-y divide-gray-300 w-full">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-right">Updated</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-2 sm:pr-4 flex justify-end">
                                <span class="sr-only">View</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="department in departments" :key="department.id">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ department.name }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right">
                                {{ new Date(Date.parse(department.updated_at)).toLocaleString() }}
                            </td>
                            <td class="align-top py-4 pl-4 text-xs text-right font-medium sm:pl-0 flex pr-2 sm:pr-4 justify-end">
                                <PencilSquareIcon @click="editDepartment(department.id)" class="-mr-0.5 h-4 w-4 mt-1" aria-hidden="true" />
                                <Link :href="'/departments/' + department.id" method="delete" class="ml-2">
                                    <TrashIcon class="-mr-0.5 h-4 w-4 mt-1" aria-hidden="true" />
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Modal :open="showModal" @close="showModal = false" @save="saveDepartment" id="modal">
            <template #icon><PencilSquareIcon class="h-6 w-6 text-slate-600" aria-hidden="true" /></template>
            <template #title>Edit Department</template>
            <div class="gap-x-6 w-full">
                <div class="sm:w-full">
                    <label for="title" class="block mt-5 text-sm font-medium leading-6 text-gray-900">Name</label>
                    <div class="mt-2">
                        <div class="flex sm:max-w-md">
                            <input type="text" name="name" v-model="curDepartment.name" id="name" class="block sm:w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Department name" />
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

const editDepartment = (id) => {
    const url = '/departments/' + id;
    axios.get(url).then(res => {
        curDepartment.value = res.data;
        showModal.value = true;
    })
}

const storeDepartment = () => {
    const url = '/departments/';
    router.post(url, {
            'name': curDepartment.value.name,
        },
        {
            preserveState: true,
            preserveScroll: true,
        });
}

const updateDepartment = (id) => {
    const url = '/departments/' + id;
    router.put(url, {
            'name': curDepartment.value.name,
        },
        {
            preserveState: true,
            preserveScroll: true,
        });
}

const saveDepartment = () => {
    if (curDepartment.value.id)
        updateDepartment(curDepartment.value.id);
    else
        storeDepartment();

    curDepartment.value = { id: null, name: null };
    showModal.value = false;
}

let curDepartment = ref({
    id: null,
    name: null,
})

let props = defineProps({
    departments: Object,
})
</script>

<style scoped>

</style>
