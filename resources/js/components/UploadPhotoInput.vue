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

const choosePhoto = (event) => {
    const file = event.target.files[0] ?? null

    if (file && file.size > 3072  * 1024) {
        props.form.setError('photo', 'The photo field must not be greater than 3024 kilobytes.')
        event.target.value = ''
        props.form.photo = null

        return
    }

    props.form.photo = file;
}

</script>

<template>
    <div class="flex flex-col">
        <div class="relative">

            <input type="file" ref="photoInput" @change="choosePhoto" @input="form.photo = $event.target.files[0]; form.clearErrors('photo')"
                   accept="image/png, image/jpeg, image/webp"
                   class="border rounded-md w-full px-3 py-2 pr-12 hover:file:bg-gray-300">
            <button v-if="visibleCancelPhotoBtn" type="button" @click="cancelPhoto()"
                    class="absolute right-0.5 rounded  px-3 py-2 hover:bg-gray-300">✕
            </button>
        </div>
        <div v-if="form.errors.photo" class="text-red-500">{{ form.errors.photo }}</div>
    </div>
</template>

