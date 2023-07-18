<template>
    <table class="min-w-full divide-y divide-gray-300 w-full">
        <thead>
        <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Period</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-right">Patients</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-right">Commissions</th>
            <th scope="col" class="relative py-3.5 pl-3 pr-10 sm:pr-4 flex justify-end">
                <button type="button" @click="createStat" title="Create new stat" class="inline-flex items-center gap-x-2 rounded-md bg-indigo-500 ml-3 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <PlusIcon class="-mr-0.5 h-5 w-5" aria-hidden="true" />
                </button>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(stat, i) in stats" :key="i">
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ stat.period.substring(0, 7) }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right">{{ stat.num_patients }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right">{{ stat.comm.toLocaleString() }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right flex justify-end pr-5">
                <PencilSquareIcon @click="editStat(i)" class="-mr-0.5 h-4 w-4" aria-hidden="true" />
                <Link method="delete" :href="'/users/' + props.user.id + '/stats/' + stat.id"><TrashIcon class="h-4 w-4 ml-2" /></Link>
            </td>
        </tr>
        </tbody>
    </table>
    <Modal :open="showModal" @close="showModal = false" @save="saveStat" id="modal">
        <template #icon><PencilSquareIcon class="h-6 w-6 text-slate-600" aria-hidden="true" /></template>
        <template #title>Add Stat for {{ new Date().getFullYear() }}</template>
        <div class="space-y-6 sm:space-y-5">
            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="month" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Month:</label>
                <div class="mt-2 sm:col-span-2 sm:mt-0">
                    <select v-model="form.month" id="month" name="month" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6 pl-2">
                        <option v-for="(name, id) in props.months" :key="id" :value="id">{{ name }}</option>
                    </select>
                </div>
            </div>
            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="num_patients" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Patients:</label>
                <div class="mt-2 sm:col-span-2 sm:mt-0">
                    <input v-model="form.num_patients" type="text" name="num_patients" id="num_patients" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" />
                    <div v-if="form.errors.num_patients">
                        <span class="text-sm text-red-400 mt-2">{{ form.errors.num_patients }}</span>
                    </div>
                </div>
            </div>
            <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-y sm:border-gray-200 sm:py-5">
                <label for="comm" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Commission:</label>
                <div class="mt-2 sm:col-span-2 sm:mt-0">
                    <input v-model="form.comm" type="text" name="comm" id="comm" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" />
                    <div v-if="form.errors.comm">
                        <span class="text-sm text-red-400 mt-2">{{ form.errors.comm }}</span>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import {ref} from "vue";
import {Link, router, useForm} from "@inertiajs/vue3";
import { PencilSquareIcon, PlusIcon, TrashIcon } from "@heroicons/vue/24/outline";
import Modal from "@/Components/Pulse/Modal.vue";

const showModal = ref(false);

const props = defineProps({
    months: Array,
    stats: Object,
    user: Object,
});

const form = useForm({
    'month': null,
    'num_patients': null,
    'comm': null,
    '_method': null,
});

const createStat = () => {
    form.month = new Date().getMonth() + 1;
    form.num_patients = null;
    form.comm = null;
    form._method = null,
    showModal.value = true;
}

const editStat = (i) => {
    // const url = '/users/' + form.user_id + '/stats/' + id;
    // alert(url);
    // axios.get(url).then(res => {
    //     form.value = res.data;
    //     showModal.value = true;
    // })

    form.id = props.stats[i].id;
    form.month = (new Date(props.stats[i].period).getMonth()) + 2;
    form.num_patients = props.stats[i].num_patients;
    form.comm = props.stats[i].comm;
    form._method = 'PUT';

    showModal.value = true;
}

const saveStat = () => {
    let url = '/users/' + props.user.id + '/stats';
    if (form.id)
        url += '/' + form.id;

    form.post(url, {
        preserveScroll: true,
        preserveState: true,
        // onSuccess: showModal.value = false,
    });

    // showModal.value = false;
    // alert(url);
    // router.post(url, {
    //         'title': userStat.value.title,
    //         'content': userStat.value.content,
    //     },
    //     {
    //         preserveState: true,
    //         preserveScroll: true,
    //     }
    // );
}

</script>

<style scoped>

</style>
