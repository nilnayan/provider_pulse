<template>
    <Head title="Users" />

    <MainLayout>
        <template #header>User Profile</template>

        <div class="py-6">
            <div class="bg-white shadow-sm sm:rounded-lg max-w-7xl mx-auto sm:px-5 sm:py-10 md:grid md:grid-cols-4 md:gap-1">
                <div class="overflow-hidden md:col-span-3 md:mr-10 px-5 py-6">
                    <div>
                        <div class="px-4 sm:px-0">
                            <h3 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h3>
                            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Personal details of the provider.</p>
                        </div>
                        <div class="mt-6 border-t border-gray-100">
                            <dl class="divide-y divide-gray-100">
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Full name</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        {{ props.user.first_name }} {{ props.user.last_name }}
                                    </dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Email Address</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ props.user.email }}</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Phone</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ props.user.phone }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <div>
                        <div class="mt-10 px-4 sm:px-0">
                            <h3 class="text-base font-semibold leading-7 text-gray-900">Employee Information</h3>
                            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Employment details of the provider.</p>
                        </div>
                        <div class="mt-6 border-t border-gray-100">
                            <dl class="divide-y divide-gray-100">
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Access Level</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        {{ props.access_level.name }}
                                    </dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Department</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ props.department.name }}</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Job Title</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ props.job_title.name }}</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Employee Status</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ props.employee_status.name }}</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Satisfaction Level</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ props.satisfaction_level.name }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <div v-if="props.user.access_level_id === 3">
                        <div class="mt-10 px-4 sm:px-0">
                            <h3 class="text-base font-semibold leading-7 text-gray-900">Productivity Stats</h3>
                            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Performance records of the provider.</p>
                        </div>
                        <div class="mt-6 border-t border-gray-100">
                            <ShowStats :months="months" :stats="user_stats" />
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden py-6">
                    <div class="text-sm">
                        <div class="ml-5 px-4 sm:px-0">
                            <img v-if="user.photo" :src="imageUrl" alt="avatar" class="rounded-full h-12 w-12 object-cover" aria-hidden="true" />
                            <UserCircleIcon v-else class="h-12 w-12 text-gray-300" aria-hidden="true" />
                        </div>
                        <div class="mt-10 px-4 sm:px-0">
                            <h3 class="text-base font-semibold leading-7 text-gray-900">Start Date</h3>
                            {{ user.start_dt }}
                        </div>
                        <div class="mt-10 px-4 sm:px-0">
                            <h3 class="text-base font-semibold leading-7 text-gray-900">Next Review Date</h3>
                            {{ user.next_review_dt }}
                        </div>
                        <div class="mt-10 px-4 sm:px-0">
                            <h3 class="text-base font-semibold leading-7 text-gray-900">Recent Notes</h3>
                            <Link :href="'/users/' + user.id + '/notes'" class="text-sm text-indigo-500">View All &rarr;</Link>
                        </div>
                        <div class="mt-3">
                            <div v-for="note in user_notes" :key="note.id" class="mt-5">
                                {{ note.title }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mt-10 px-4 sm:px-0">
                            <h3 class="text-base font-semibold leading-7 text-gray-900">Recent Files</h3>
                            <Link :href="'/users/' + user.id + '/files'" class="text-sm text-indigo-500">View All &rarr;</Link>
                        </div>
                        <div class="mt-6">
                            <div v-for="file in user_files" :key="file.id" class="mt-5">
                                {{ file.title }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-16">
                        <Link :href="'/users/' + user.id + '/edit'" type="button" title="Edit user" class="inline-flex items-center gap-x-2 rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <PencilSquareIcon class="-mr-0.5 h-5 w-5" aria-hidden="true" /> Edit
                        </Link>
                        <Link :href="'/users/' + user.id + '/delete'" method="delete" type="button" @click="confirmDelete" title="Delete user" class="inline-flex items-center gap-x-2 rounded-md bg-indigo-500 ml-2 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <TrashIcon class="-mr-0.5 h-5 w-5" aria-hidden="true" /> Delete
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import { PencilSquareIcon, TrashIcon, UserCircleIcon } from "@heroicons/vue/24/outline";
import ShowStats from "@/Pages/Users/ShowStats.vue";

const confirmDelete = (e) => {
    confirm('Delete this user?') || e.preventDefault();
}

let props = defineProps({
    user: Object,
    access_level: Object,
    department: Object,
    employee_status: Object,
    job_title: Object,
    months: Object,
    satisfaction_level: Object,
    user_notes: Object,
    user_stats: Object,
})
</script>
