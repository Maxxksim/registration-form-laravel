<script setup>
import StepOne from '@/components/StepOne';

const { countries } = defineProps({
    countries: Array,
});

</script>

<template>

    <StepOne :countries="countries"/>

</template>
