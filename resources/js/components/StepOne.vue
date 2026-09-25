<script setup>
import {Form} from "@inertiajs/vue3";
import {ref, onMounted} from 'vue';
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

const birthdate = ref(null);
const country = ref('')

const flatPickerConfig = {
    maxDate: new Date().toISOString().split('T')[0],
    format: 'Y-m-d',
}

const { countries } = defineProps({
    countries: Array,
});

</script>

<template>

    <Form action="/register/steps/one" method="post" class="max-w-md mx-auto flex flex-col gap-4 p-4">
        <label class="after:ml-1 after:text-red-500 after:content-['*']">First Name</label>
        <input type="text" required name="first_name" class="border rounded-md w-full px-3 py-2">
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Last Name</label>
        <input type="text" required name="last_name" class="border rounded-md w-full px-3 py-2">
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Birthdate</label>
        <FlatPickr v-model="birthdate" name="birthdate" required :config="flatPickerConfig"
                   class="border rounded-md w-full px-3 py-2"/>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Report subject</label>
        <input type="text" required name="report_subject" class="border rounded-md w-full px-3 py-2">
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Country</label>
        <select v-model="country" name="country" required class="border rounded-md w-full px-3 py-2">
            <option v-for="country in countries" :value="country">
                {{ country }}
            </option>
        </select>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Phone</label>
        <input type="tel" required name="phone" class="border rounded-md w-full px-3 py-2">
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Email</label>
        <input type="email" required name="email" class="border rounded-md w-full px-3 py-2">
        <button type="submit" id="stepOneBtn" class="border rounded-md w-full px-3 py-2 hover:bg-gray-300">Next
        </button>
    </Form>

</template>

