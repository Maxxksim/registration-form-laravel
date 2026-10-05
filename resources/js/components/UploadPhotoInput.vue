<script setup>

import {computed, ref} from "vue";

const props = defineProps({
    form: Object
});

const photoInput = ref(null);
const visibleCancelPhotoBtn = computed(function () {
    if (props.form.photo) {
        return true;
    }
    return false;
});

function cancelPhoto() {
    props.form.photo = null;
    if (photoInput.value) {
        photoInput.value.value = ''
    }
    if (props.form.errors.photo) {
        props.form.clearErrors('photo');
    }
}

</script>

<template>
    <div class="flex flex-col">
        <div class="relative">

            <input type="file" ref="photoInput" @input="form.photo = $event.target.files[0]; form.clearErrors('photo')"
                   accept="image/png, image/jpeg, image/webp"
                   class="border rounded-md w-full px-3 py-2 pr-12 hover:file:bg-gray-300">
            <button v-if="visibleCancelPhotoBtn" type="button" @click="cancelPhoto()"
                    class="absolute right-0.5 rounded  px-3 py-2 hover:bg-gray-300">✕
            </button>
        </div>
        <div v-if="form.errors.photo" class="text-red-500">{{ form.errors.photo }}</div>
    </div>
</template>

