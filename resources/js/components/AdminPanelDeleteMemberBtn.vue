<script setup>
import {onClickOutside} from "@vueuse/core";
import {ref} from "vue";
import AdminPanelDeleteMemberConfirm from "./AdminPanelDeleteMemberConfirm.vue";

const props = defineProps({member: Object});
const isDeleting = ref(false);
const confirmationDeleting = ref(null);

onClickOutside(confirmationDeleting, () => {
    isDeleting.value = false;
});
</script>

<template>
    <div ref="confirmationDeleting">
        <button @click="isDeleting=true" class="border w-full rounded-md px-3 py-2 bg-red-300 hover:bg-red-50">Delete
        </button>
        <AdminPanelDeleteMemberConfirm v-if="isDeleting" :member="member" @show-component="isDeleting=false"/>
    </div>
</template>
