<script setup>
import {usePage} from '@inertiajs/vue3'
import {computed, ref, watchEffect} from "vue";

const page = usePage()
const error = computed(() => page.props.errors.error)
const visible = ref(false);


watchEffect(() => {
    const message = page.props.errors.error;
    if (message) {
        visible.value = true;
        setTimeout(() => (visible.value = false), 5000);
    }
});

</script>

<template>
    <div v-if="visible"
         class="fixed top-4 z-3000 w-full max-w-md text-red-700 bg-red-50 border border-red-200 rounded-md ml-5 p-3 shadow"
         :class="{ 'animate-pulse' : visible }">

        {{ error }}
    </div>
</template>

