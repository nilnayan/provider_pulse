<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Test" />

    <MainLayout>
        <template #header>Test</template>

        <div class="py-6">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">This is a test</div>
                </div>
            </div>
        </div>

    </MainLayout>
</template>
