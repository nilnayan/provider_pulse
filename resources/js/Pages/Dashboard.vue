<script setup>

import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';

import { ArrowDownIcon, ArrowUpIcon, CalendarIcon, MapPinIcon } from '@heroicons/vue/20/solid'
import { CursorArrowRaysIcon, EnvelopeOpenIcon, UsersIcon } from '@heroicons/vue/24/outline'

import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

const stats = [
    { id: 1, name: 'New Employees', stat: '71,897', icon: UsersIcon, change: '122', changeType: 'increase' },
    { id: 2, name: 'Employee Satisfaction Level', stat: '88.16%', icon: EnvelopeOpenIcon, change: '5.4%', changeType: 'increase' },
    { id: 3, name: 'Avg. Attrition Rate', stat: '3.57%', icon: CursorArrowRaysIcon, change: '0.05%', changeType: 'decrease' },
]

const stats2 = [
    { name: 'Total SOP Request', stat: '256', previousStat: '155', change: '12%', changeType: 'increase' },
    { name: 'SOP On-Time Completion Rate', stat: '77.16%', previousStat: '75.14%', change: '2.02%', changeType: 'increase' },
    { name: 'SOPs Overdue by 48hrs', stat: '3.57%', previousStat: '4.62%', change: '0.05%', changeType: 'decrease' },
]


const positions = [
    {
        id: 1,
        title: 'Friedrich Nietzche',
        type: 'Full-time',
        location: 'NYC Office:  111 Broadway',
        department: 'Cardiology',
        closeDate: '2023-03-15',
        closeDateFull: 'March 15, 2023',
    },
    {
        id: 2,
        title: 'Arthur Schopenhauer',
        type: 'Full-time',
        location: 'NYC Office: 75 Park Ave S',
        department: 'Dermatology',
        closeDate: '2023-03-20',
        closeDateFull: 'March 20, 2023',
    },
    {
        id: 2,
        title: 'Soren Kierkegaard',
        type: 'Full-time',
        location: 'NYC Office: 75 Park Ave S',
        department: 'Psychiatry',
        closeDate: '2023-03-28',
        closeDateFull: 'March 28, 2023',
    },
    {
        id: 3,
        title: 'Emmanuel Kant',
        type: 'Full-time',
        location: 'New Jersey: Freehold',
        department: 'Epidemiology',
        closeDate: '2023-04-10',
        closeDateFull: 'April 10, 2023',
    },
]

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const chartData = {
    labels: [ 'January', 'February', 'March' ],
    datasets: [ { data: [40, 20, 12] } ],

    // use "Total Sales" for legend
}

const chartOptions = {
    responsive: true,
    plugins: {
        legend: {
            display: false
        }
    }
}



</script>

<template>
    <Head title="Dashboard" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div>
            <h3 class="text-base font-semibold leading-6 text-gray-900">At a Glance</h3>

            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <div v-for="item in stats" :key="item.id" class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow sm:px-6 sm:pt-6">
                    <dt>
                        <div class="absolute rounded-md bg-indigo-500 p-3">
                            <component :is="item.icon" class="h-6 w-6 text-white" aria-hidden="true" />
                        </div>
                        <p class="ml-16 truncate text-sm font-medium text-gray-500">{{ item.name }}</p>
                    </dt>
                    <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                        <p class="text-2xl font-semibold text-gray-900">{{ item.stat }}</p>
                        <p :class="[item.changeType === 'increase' ? 'text-green-600' : 'text-red-600', 'ml-2 flex items-baseline text-sm font-semibold']">
                            <ArrowUpIcon v-if="item.changeType === 'increase'" class="h-5 w-5 flex-shrink-0 self-center text-green-500" aria-hidden="true" />
                            <ArrowDownIcon v-else class="h-5 w-5 flex-shrink-0 self-center text-red-500" aria-hidden="true" />
                            <span class="sr-only"> {{ item.changeType === 'increase' ? 'Increased' : 'Decreased' }} by </span>
                            {{ item.change }}
                        </p>
                        <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                            <div class="text-sm">
                                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    View all<span class="sr-only"> {{ item.name }} stats</span></a
                                >
                            </div>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>

        <div style="height: 50px"></div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-base font-semibold leading-6 text-gray-900 mt-50">Recent Sales (x $1,000)</h3>
                <div class="overflow-hidden bg-white shadow sm:rounded-md mt-5 p-5">
                    <Bar
                        id="my-chart-id"
                        :options="chartOptions"
                        :data="chartData"
                    />
                </div>
            </div>
            <div>
                <h3 class="text-base font-semibold leading-6 text-gray-900 mt-50">Upcoming Reviews</h3>
                <div class="overflow-hidden bg-white shadow sm:rounded-md mt-5">
                    <ul role="list" class="divide-y divide-gray-200">
                        <li v-for="position in positions" :key="position.id">
                            <a href="#" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <p class="truncate text-sm font-medium text-indigo-600">{{ position.title }}</p>
                                        <div class="ml-2 flex flex-shrink-0">
                                            <p class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">{{ position.type }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm text-gray-500">
                                                <UsersIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                                {{ position.department }}
                                            </p>
                                            <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                <MapPinIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                                {{ position.location }}
                                            </p>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                            <CalendarIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                            <p>
                                                Next Review:
                                                {{ ' ' }}
                                                <time :datetime="position.closeDate">{{ position.closeDateFull }}</time>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div style="height: 50px"></div>

        <div>
            <h3 class="text-base font-semibold leading-6 text-gray-900">SOP Stats</h3>
            <dl class="mt-5 grid grid-cols-1 divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow md:grid-cols-3 md:divide-y-0 md:divide-x">
                <div v-for="item in stats2" :key="item.name" class="px-4 py-5 sm:p-6">
                    <dt class="text-base font-normal text-gray-900">{{ item.name }}</dt>
                    <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                        <div class="flex items-baseline text-2xl font-semibold text-indigo-600">
                            {{ item.stat }}
                            <span class="ml-2 text-sm font-medium text-gray-500">from {{ item.previousStat }}</span>
                        </div>

                        <div :class="[item.changeType === 'increase' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800', 'inline-flex items-baseline rounded-full px-2.5 py-0.5 text-sm font-medium md:mt-2 lg:mt-0']">
                            <ArrowUpIcon v-if="item.changeType === 'increase'" class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-green-500" aria-hidden="true" />
                            <ArrowDownIcon v-else class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-red-500" aria-hidden="true" />
                            <span class="sr-only"> {{ item.changeType === 'increase' ? 'Increased' : 'Decreased' }} by </span>
                            {{ item.change }}
                        </div>
                    </dd>
                </div>
            </dl>
        </div>


    </MainLayout>
</template>
