<script setup>
import {useForm, Link, usePage} from "@inertiajs/vue3";
import Map from "@/components/Map.vue";
import Error from "@/components/Error.vue";
import {computed, ref} from "vue";
import UploadPhotoInput from "@/components/UploadPhotoInput.vue";

const page = usePage();

const form = useForm({
    _token: page.props.csrf_token,
    company: null,
    position: null,
    about_me: null,
    photo: null
});

</script>

<template>
    <Error/>
    <Map></Map>
    <form @submit.prevent="form.post('/register/steps/two', {preserveScroll: 'errors'})" enctype="multipart/form-data"
          class="max-w-md mx-auto flex flex-col gap-4 p-4">
        <div class="flex flex-col gap-1">
            <label for="company" class="text-sm font-medium">Company</label>
            <input type="text" v-model="form.company" maxlength="255" @input="form.clearErrors('company')" autocomplete="off"
                   class="border rounded-md w-full px-3 py-2">
            <div v-if="form.errors.company" class="text-red-500">{{ form.errors.company }}</div>
        </div>

        <div class="flex flex-col gap-1">
            <label for="position" class="text-sm font-medium">Position</label>
            <input type="text" v-model="form.position" maxlength="255" @input="form.clearErrors('position')" autocomplete="off"
                   class="border rounded-md w-full px-3 py-2">
            <div v-if="form.errors.position" class="text-red-500">{{ form.errors.position }}</div>
        </div>

        <div class="flex flex-col gap-1">
            <label for="about_me" class="text-sm font-medium">About me</label>
            <textarea name="about_me" v-model="form.about_me" maxlength="500" @input="form.clearErrors('about_me')" autocomplete="off" rows="5"
                      class="border rounded-md w-full px-3 py-2"></textarea>
            <div v-if="form.errors.about_me" class="text-red-500">{{ form.errors.about_me }}</div>
        </div>
        <label for="photo" class="text-sm font-medium">Photo</label>
        <UploadPhotoInput :form="form" />
        <div class="flex gap-3">
            <Link href="/register/steps/one" class="border rounded-md w-full px-3 py-2 text-center hover:bg-gray-300">Back</Link>
            <button type="submit" :disabled="form.processing"
                    class="border rounded-md w-full px-3 py-2 hover:bg-gray-300">Finish
            </button>
        </div>

    </form>

</template>

