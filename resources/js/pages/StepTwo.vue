<script setup>
import {useForm, Link} from "@inertiajs/vue3";
import {data} from "autoprefixer";
import Map from "@/components/Map.vue";
import OrderStepError from "@/components/OrderStepError.vue";


const form = useForm({
    company: null,
    position: null,
    about_me: null,
    photo: null
}, data);

</script>

<template>
    <OrderStepError/>
    <Map></Map>
    <form @submit.prevent="form.post('/register/steps/two')" enctype="multipart/form-data"
          class="max-w-md mx-auto flex flex-col gap-4 p-4">
        <div class="flex flex-col gap-1">
            <label for="company" class="text-sm font-medium">Company</label>
            <input type="text" v-model="form.company" maxlength="255" autocomplete="off"
                   class="border rounded-md w-full px-3 py-2">
            <div v-if="form.errors.company" class="text-red-500">{{ form.errors.company }}</div>
        </div>

        <div class="flex flex-col gap-1">
            <label for="position" class="text-sm font-medium">Position</label>
            <input type="text" v-model="form.position" maxlength="255" autocomplete="off"
                   class="border rounded-md w-full px-3 py-2">
            <div v-if="form.errors.position" class="text-red-500">{{ form.errors.position }}</div>
        </div>

        <div class="flex flex-col gap-1">
            <label for="about_me" class="text-sm font-medium">About me</label>
            <textarea name="about_me" v-model="form.about_me" maxlength="500" autocomplete="off" rows="5"
                      class="border rounded-md w-full px-3 py-2"></textarea>
            <div v-if="form.errors.about_me" class="text-red-500">{{ form.errors.about_me }}</div>
        </div>
        <label for="photo" class="text-sm font-medium">Photo</label>
        <div class="flex  flex-col gap-1">
            <div class="relative">
                <input type="file" @input="form.photo = $event.target.files[0]" autocomplete="off"
                       accept="image/png, image/jpeg, image/webp"
                       class="border rounded-md w-full px-3 py-2  pr-12 hover:file:bg-gray-300">
                <button type="button"
                        class="hidden absolute right-0.5 rounded  px-3 py-2 hover:bg">✕
                </button>
                <div v-if="form.errors.photo" class="text-red-500">{{ form.errors.photo }}</div>
            </div>
        </div>

        <div class="flex gap-3">
            <Link href="/register/steps/one" class="border rounded-md w-full px-3 py-2 hover:bg-gray-300">Back</Link>
            <button type="submit" :disabled="form.processing"
                    class="border rounded-md w-full px-3 py-2 hover:bg-gray-300">Finish
            </button>
        </div>

    </form>

</template>

