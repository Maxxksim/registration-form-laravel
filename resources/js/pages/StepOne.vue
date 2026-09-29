<script setup xmlns="http://www.w3.org/1999/html">
import {useForm} from "@inertiajs/vue3";
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import IntlTelInput from "@intl-tel-input/vue";
import "intl-tel-input/styles";

const flatPickerConfig = {
    maxDate: 'today',
    dateFormat: 'Y-m-d',
}

const {countries} = defineProps({
    countries: Array,
    initialCountry: String
});

const form = useForm({
    first_name: null,
    last_name: null,
    birthdate: null,
    report_subject: null,
    country: null,
    phone: null,
    email: null
});

</script>

<template>
    <form @submit.prevent="form.post('/register/steps/one')" method="post"
          class="max-w-md mx-auto flex flex-col gap-4 p-4">
        <label class="after:ml-1 after:text-red-500 after:content-['*']">First Name</label>
        <input type="text" maxlength="100" v-model="form.first_name" required class="border rounded-md w-full px-3 py-2">
        <div v-if="form.errors.first_name" class="text-red-500">{{ form.errors.first_name }}</div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Last Name</label>
        <input type="text" v-model="form.last_name" maxlength="100" required class="border rounded-md w-full px-3 py-2">
        <div v-if="form.errors.last_name" class="text-red-500">{{ form.errors.last_name }}</div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Birthdate</label>
        <FlatPickr required :config="flatPickerConfig"
                   class="border rounded-md w-full px-3 py-2"/>
        <div v-if="form.errors.birthdate" class="text-red-500">{{ form.errors.birthdate }}</div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Report subject</label>
        <input type="text" v-model="form.report_subject" maxlength="255" required class="border rounded-md w-full px-3 py-2">
        <div v-if="form.errors.report_subject" class="text-red-500">{{ form.errors.report_subject }}</div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Country</label>
        <select required v-model="form.country" class="border rounded-md w-full px-3 py-2">
            <option v-for="country in countries" :value="country">
                {{ country }}
            </option>
        </select>
        <div v-if="form.errors.country" class="text-red-500">{{ form.errors.country }}</div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Phone</label>
        <IntlTelInput v-model="form.phone" :hidden-inputs="() => ({ phone: 'phone' })"
                      :input-props="{ placeholder: 'Enter your number', class: 'border rounded-md w-full px-3 py-2' }"
                      :initial-country="initialCountry"
                      :load-utils="() => import('intl-tel-input/utils')"/>
        <div v-if="form.errors.phone" class="text-red-500">{{ form.errors.phone }}</div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">Email</label>
        <input type="email" v-model="form.email" maxlength="255" required class="border rounded-md w-full px-3 py-2">
        <div v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</div>
        <button type="submit" :disabled="form.processing" id="stepOneBtn"
                class="border rounded-md w-full px-3 py-2 hover:bg-gray-300">Next
        </button>
    </form>
</template>

