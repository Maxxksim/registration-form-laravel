<script setup>
import {Form} from "@inertiajs/vue3";
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import IntlTelInput from "@intl-tel-input/vue";
import "intl-tel-input/styles";

const flatPickerConfig = {
    maxDate: 'today',
    dateFormat: 'Y-m-d',
}

const { countries } = defineProps({
    countries: Array,
    initialCountry : String
});

</script>

<template>

    <Form  action="/register/steps/one" method="post" #default="{ errors, processing }" class="max-w-md mx-auto flex flex-col gap-4 p-4">
        <label class="after:ml-1 after:text-red-500 after:content-['*']">First Name</label>
        <input type="text" maxlength="100" required name="first_name" class="border rounded-md w-full px-3 py-2">
        <div v-if="errors.first_name" class="text-red-500">{{ errors.first_name }}</div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Last Name</label>
        <input type="text" maxlength="100" required name="last_name" class="border rounded-md w-full px-3 py-2">
        <div v-if="errors.last_name" class="text-red-500">{{ errors.last_name }}</div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Birthdate</label>
        <FlatPickr  name="birthdate" required :config="flatPickerConfig"
                   class="border rounded-md w-full px-3 py-2"/>
        <div v-if="errors.birthdate" class="text-red-500">{{ errors.birthdate }}</div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Report subject</label>
        <input type="text" maxlength="255" required name="report_subject" class="border rounded-md w-full px-3 py-2">
        <div v-if="errors.report_subject" class="text-red-500">{{ errors.report_subject }}</div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Country</label>
        <select  name="country" required class="border rounded-md w-full px-3 py-2">
            <option v-for="country in countries" :value="country">
                {{ country }}
            </option>
        </select>
        <div v-if="errors.country" class="text-red-500">{{ errors.country }}</div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Phone</label>
        <IntlTelInput :input-props="{ name: 'phone' }" :initial-country='initialCountry' :class-names="{ input: 'border rounded-md w-full px-3 py-2' }"  :load-utils="() => import('intl-tel-input/utils')"/>
        <div v-if="errors.phone" class="text-red-500">{{ errors.phone }}</div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Email</label>
        <input type="email" maxlength="255" required name="email" class="border rounded-md w-full px-3 py-2">
        <div v-if="errors.email" class="text-red-500">{{ errors.email }}</div>
        <button type="submit" id="stepOneBtn" class="border rounded-md w-full px-3 py-2 hover:bg-gray-300">Next
        </button>
    </Form>

</template>

