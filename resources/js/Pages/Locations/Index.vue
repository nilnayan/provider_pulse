<template>
    <Head title="Locations" />
    <MainLayout>
        <template #header>Locations</template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-5 py-6">
                    <div class="flex justify-end my-2">
                        <button type="button" @click="showModal = true" title="Create new location" class="inline-flex items-center gap-x-2 rounded-md bg-indigo-500 ml-3 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <PlusIcon class="-mr-0.5 h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>
                    <table class="min-w-full divide-y divide-gray-300 w-full">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Addr Line 1</th>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Addr Line 2</th>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">City</th>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">State</th>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Zip</th>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Phone</th>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Email</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-right">Updated</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-2 sm:pr-4 flex justify-end">
                                <span class="sr-only">View</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="location in locations" :key="location.id">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ location.name }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ location.addr1 }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ location.addr2 }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ location.city }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ location.state }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ location.zip }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ location.phone }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ location.email }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right">
                                {{ new Date(Date.parse(location.updated_at)).toLocaleString() }}
                            </td>
                            <td class="align-top py-4 pl-4 text-xs text-right font-medium sm:pl-0 flex pr-2 sm:pr-4 justify-end">
                                <PencilSquareIcon @click="editLocation(location.id)" class="-mr-0.5 h-4 w-4 mt-1" aria-hidden="true" />
                                <Link :href="'/locations/' + location.id" method="delete" class="ml-2">
                                    <TrashIcon class="-mr-0.5 h-4 w-4 mt-1" aria-hidden="true" />
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Modal :open="showModal" @close="showModal = false" @save="saveLocation" id="modal">
            <template #icon><PencilSquareIcon class="h-6 w-6 text-slate-600" aria-hidden="true" /></template>
            <template #title>Edit Location</template>
            <div class="gap-x-6 w-full">
                <div class="sm:w-full">
                    <label for="name" class="block mt-5 text-sm font-medium leading-6 text-gray-900">Name</label>
                    <div class="mt-2">
                        <div class="flex sm:max-w-md">
                            <input type="text" name="name" v-model="curLocation.name" id="name" class="block sm:w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Location name" />
                        </div>
                    </div>
                </div>
                <div class="sm:w-full">
                    <label for="addr1" class="block mt-5 text-sm font-medium leading-6 text-gray-900">Address Line 1</label>
                    <div class="mt-2">
                        <div class="flex sm:max-w-md">
                            <input type="text" name="addr1" v-model="curLocation.addr1" id="addr1" class="block sm:w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Location addr1" />
                        </div>
                    </div>
                </div>
                <div class="sm:w-full">
                    <label for="addr2" class="block mt-5 text-sm font-medium leading-6 text-gray-900">Address Line 2</label>
                    <div class="mt-2">
                        <div class="flex sm:max-w-md">
                            <input type="text" name="addr2" v-model="curLocation.addr2" id="addr2" class="block sm:w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Location addr2" />
                        </div>
                    </div>
                </div>
                <div class="sm:w-full">
                    <label for="city" class="block mt-5 text-sm font-medium leading-6 text-gray-900">City</label>
                    <div class="mt-2">
                        <div class="flex sm:max-w-md">
                            <input type="text" name="city" v-model="curLocation.city" id="city" class="block sm:w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Location city" />
                        </div>
                    </div>
                </div>
                <div class="sm:w-full">
                    <label for="state" class="block mt-5 text-sm font-medium leading-6 text-gray-900">State</label>
                    <div class="mt-2">
                        <div class="flex sm:max-w-md">
                            <input type="text" name="state" v-model="curLocation.state" id="state" class="block sm:w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Location state" />
                        </div>
                    </div>
                </div>
                <div class="sm:w-full">
                    <label for="zip" class="block mt-5 text-sm font-medium leading-6 text-gray-900">Zip</label>
                    <div class="mt-2">
                        <div class="flex sm:max-w-md">
                            <input type="text" name="zip" v-model="curLocation.zip" id="zip" class="block sm:w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Location zip" />
                        </div>
                    </div>
                </div>
                <div class="sm:w-full">
                    <label for="phone" class="block mt-5 text-sm font-medium leading-6 text-gray-900">Phone</label>
                    <div class="mt-2">
                        <div class="flex sm:max-w-md">
                            <input type="text" name="phone" v-model="curLocation.phone" id="phone" class="block sm:w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Location phone" />
                        </div>
                    </div>
                </div>
                <div class="sm:w-full">
                    <label for="email" class="block mt-5 text-sm font-medium leading-6 text-gray-900">Email</label>
                    <div class="mt-2">
                        <div class="flex sm:max-w-md">
                            <input type="text" name="email" v-model="curLocation.email" id="email" class="block sm:w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Location email" />
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

const editLocation = (id) => {
    const url = '/locations/' + id;
    axios.get(url).then(res => {
        curLocation.value = res.data;
        showModal.value = true;
    })
}

const storeLocation = () => {
    const url = '/locations/';
    router.post(url, {
            'name': curLocation.value.name,
        },
        {
            preserveState: true,
            preserveScroll: true,
        });
}

const updateLocation = (id) => {
    const url = '/locations/' + id;
    router.put(url, {
            'name': curLocation.value.name,
        },
        {
            preserveState: true,
            preserveScroll: true,
        });
}

const saveLocation = () => {
    if (curLocation.value.id)
        updateLocation(curLocation.value.id);
    else
        storeLocation();

    curLocation.value = { id: null, name: null };
    showModal.value = false;
}

let curLocation = ref({
    id: null,
    name: null,
})

let props = defineProps({
    locations: Object,
    states: Object,
})
</script>

<style scoped>

</style>
