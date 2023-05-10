<script setup>
import VueTailwindDatePicker from 'vue-tailwind-datepicker'
import { ref } from 'vue'

const dateValue = ref('')
</script>

<template>
    <VueTailwindDatePicker v-model="dateValue" />
</template>
