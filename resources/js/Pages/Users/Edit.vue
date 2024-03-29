<script setup>
import { reactive, ref} from 'vue';
import { router, useForm } from "@inertiajs/vue3";
import moment from 'moment';
import VueTailwindDatepicker from 'vue-tailwind-datepicker'
import { UserCircleIcon } from '@heroicons/vue/24/outline';
import MainLayout from "@/Layouts/MainLayout.vue";

let props = defineProps({
    user: Object,
    access_levels: Object,
    departments: Object,
    employee_statuses: Object,
    job_titles: Object,
    photo_url: String,
    satisfaction_levels: Object,
});

const currentDate = moment(new Date()).format('MM/DD/YYYY');
const initialDate = ref(currentDate);
const imageUrl = ref(props.photo_url);

const formatter = ref({
    date: 'MM/DD/YYYY',
    month: 'MMM'
})

const  addPhoto = (event) => {
    const file = event.target.files[0];
    form.photo = file;
    form.photo_action = 'add';
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = (e) => {
        imageUrl.value = e.target.result;
    };
}

const delPhoto = () => {
    form.photo_action = 'del';
    imageUrl.value = null;
}

let form = useForm({
    'id': props.user.id,
    'first_name': props.user.first_name,
    'last_name': props.user.last_name,
    'email': props.user.email,
    'password': null,
    'password_confirmation': null,
    'phone': props.user.phone,
    'access_level_id': props.user.access_level_id,
    'department_id': props.user.department_id,
    'status_id': props.user.status_id,
    'job_title_id': props.user.job_title_id,
    'satisfaction_level_id': props.user.satisfaction_level_id,
    'start_dt': props.user.start_dt,
    'next_review_dt': props.user.next_review_dt,
    'photo': null,
    'photo_action': null,
    '_method': 'PUT',
});

let submit = () => {
    form.post('/users/' + props.user.id);
}
</script>

<template>
    <Head title="Edit User" />

    <MainLayout>
        <template #header>Edit User Profile</template>

        <div class="mt-8 sm:mx-auto sm:w-full">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-8 divide-y divide-gray-200" @submit.prevent="submit">
                    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">

                        <div class="space-y-6 pt-8 sm:space-y-5 sm:pt-10">
                            <div>
                                <h3 class="text-base font-semibold leading-6 text-gray-900">Personal Information</h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">Use a permanent address where you can receive mail.</p>
                            </div>
                            <div class="space-y-6 sm:space-y-5">
                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">First Name</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <input v-model="form.first_name" type="text" name="first_name" id="first_name" autocomplete="given-name" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" />
                                        <div v-if="form.errors.first_name">
                                            <span class="text-sm text-red-400 mt-2">{{ form.errors.first_name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Last Name</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <input v-model="form.last_name" type="text" name="last_name" id="last_name" autocomplete="family-name" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" />
                                        <div v-if="form.errors.last_name">
                                            <span class="text-sm text-red-400 mt-2">{{ form.errors.last_name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Email Address</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <input v-model="form.email" id="email" name="email" type="email" autocomplete="email" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" />
                                        <div v-if="form.errors.email">
                                            <span class="text-sm text-red-400 mt-2">{{ form.errors.email }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Password</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <input v-model="form.password" id="password" name="password" type="password" autocomplete="new-password" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" />
                                        <div v-if="form.errors.password">
                                            <span class="text-sm text-red-400 mt-2">{{ form.errors.password }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Confirm Password</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <input v-model="form.password_confirmation" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" />
                                        <div v-if="form.errors.password_confirmation">
                                            <span class="text-sm text-red-400 mt-2">{{ form.errors.password_confirmation }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="phone" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Phone</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <input v-model="form.phone" id="phone" name="phone" type="text" autocomplete="phone" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" />
                                        <div v-if="form.errors.phone">
                                            <span class="text-sm text-red-400 mt-2">{{ form.errors.phone }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="photo" class="block mt-3 text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Photo</label>
                                    <div v-if="!imageUrl" class="mt-2 flex items-center gap-x-3">
                                        <UserCircleIcon class="h-12 w-12 text-gray-300" aria-hidden="true" />
                                        <label class="ring-1 ring-inset ring-gray-300 hover:bg-gray-50 text-gray-900 py-1 px-3 rounded">
                                            Choose Image
                                            <input type="file" name="photo" id="photo"  ref="photo" class="hidden" @change="addPhoto" accept=".jpg,.jpeg,.png,.gif" />
                                        </label>
                                    </div>
                                    <div v-else class="mt-2 flex items-center gap-x-3">
                                        <img :src="imageUrl" alt="avatar" class="rounded-full h-12 w-12 object-cover" aria-hidden="true" />
                                        <label class="ring-1 ring-inset ring-gray-300 hover:bg-gray-50 text-gray-900 py-1 px-3 rounded">
                                            <a @click="delPhoto">Remove Image</a>
                                        </label>
                                    </div>
                                </div>
                                <div v-if="form.errors.photo" class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                    <div class="sm:col-span-1"></div>
                                    <span class="text-sm text-red-400 mt-2">{{ form.errors.photo }}</span>
                                </div>

                            </div>
                        </div>

                        <div class="space-y-6 pt-8 sm:space-y-5 sm:pt-10">
                            <div>
                                <h3 class="text-base font-semibold leading-6 text-gray-900">Employee Information</h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">Use a permanent address where you can receive mail.</p>
                            </div>
                            <div class="space-y-6 sm:space-y-5">

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="access_level_id" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Access Level</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <select v-model="form.access_level_id" id="access_level_id" name="access_level_id" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6 pl-2">
                                            <option v-for="(id, name) in props.access_levels" :key="id" :value="id">{{ name }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="department_id" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Department</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <select v-model="form.department_id" id="department_id" name="department_id" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6 pl-2">
                                            <option v-for="(id, name) in props.departments" :key="id" :value="id">{{ name }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="job_title_id" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Job Title</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <select v-model="form.job_title_id" id="job_title_id" name="job_title_id" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6 pl-2">
                                            <option v-for="(id, name) in props.job_titles" :key="id" :value="id">{{ name }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="status_id" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Employee Status</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <select v-model="form.status_id" id="status_id" name="status_id" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6 pl-2">
                                            <option v-for="(id, name) in props.employee_statuses" :key="id" :value="id">{{ name }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="status_id" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Satisfaction Level</label>
                                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                                        <select v-model="form.satisfaction_level_id" id="satisfaction_level_id" name="satisfaction_level_id" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6 pl-2">
                                            <option v-for="(id, name) in props.satisfaction_levels" :key="id" :value="id">{{ name }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="start_dt" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Start Date</label>
                                    <div class="relative mt-2 sm:col-span-2 sm:mt-0">
                                        <vue-tailwind-datepicker as-single :formatter="formatter" v-model="form.start_dt" name="start_dt" :value="form.start_dt" :initial-date="initialDate" class="block w-full max-w-lg rounded-md border-0  text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" />
                                        <div v-if="form.errors.start_dt">
                                            <span class="text-sm text-red-400 mt-2">{{ form.errors.start_dt }}</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="next_review_dt" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Next Review Date</label>
                                    <div class="relative mt-2 sm:col-span-2 sm:mt-0">
                                        <vue-tailwind-datepicker as-single :formatter="formatter" v-model="form.next_review_dt" name="next_review_dt" :value="form.next_review_dt" :initial-date="initialDate" class="block w-full max-w-lg rounded-md border-0  text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" />
                                        <div v-if="form.errors.next_review_dt">
                                            <span class="text-sm text-red-400 mt-2">{{ form.errors.next_review_dt }}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="pt-5">
                        <div class="flex justify-end gap-x-3">

                            <button type="button" class="rounded-md bg-white py-2 px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" @click="goBack">Cancel</button>
                            <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </MainLayout>
</template>
