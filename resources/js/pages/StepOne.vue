<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import IntlTelInput from "@intl-tel-input/vue/with-utils";
import "intl-tel-input/styles";
import Map from "@/components/Map.vue";
import Error from "@/components/Error.vue";

const page = usePage();

const flatPickerConfig = {
    maxDate: 'today',
    dateFormat: 'Y-m-d',
    allowInput: true
}

const props = defineProps({
    countries: Object,
    initialCountry: String,
    memberData: Object
});

const member = props.memberData ?? {};

const form = useForm({
    _token: page.props.csrf_token,
    first_name: member.first_name ?? null,
    last_name: member.last_name ?? null,
    birthdate: member.birthdate ?? null,
    report_subject: member.report_subject ?? null,
    country: member.country ?? null,
    phone: member.phone ?? null,
    email: member.email ?? null
});

</script>

<template>
    <Error/>
    <Map></Map>
    <div class="flex flex-col  m-3">
        <h1 class="text-lg">To participate in the conference, please fill out the form:</h1>
    </div>

    <form @submit.prevent="form.post('/register/steps/one', {preserveScroll: 'errors'})"
          class="max-w-md mx-auto flex flex-col gap-4 p-4">
        <div class="relative z-0 w-full group"><p>Fields marked with <span class="text-red-500">*</span> are required.
        </p></div>
        <label class="after:ml-1 after:text-red-500 after:content-['*']">First Name</label>
        <input type="text" maxlength="100" v-model="form.first_name" @input="form.clearErrors('first_name')"
               autocomplete="off" required
               class="border rounded-md w-full px-3 py-2">
        <div v-if="form.errors.first_name" class="text-red-500">{{ form.errors.first_name }}</div>

        <label class="after:ml-1 after:text-red-500 after:content-['*']">Last Name</label>
        <input type="text" v-model="form.last_name" maxlength="100" @input="form.clearErrors('last_name')"
               autocomplete="off" required class="border rounded-md w-full px-3 py-2">
        <div v-if="form.errors.last_name" class="text-red-500">{{ form.errors.last_name }}</div>

        <label class="after:ml-1 after:text-red-500 after:content-['*']">Birthdate</label>
        <FlatPickr v-model="form.birthdate" @input="form.clearErrors('birthdate')" autocomplete="off" required
                   :config="flatPickerConfig"
                   class="border rounded-md w-full px-3 py-2"/>
        <div v-if="form.errors.birthdate" class="text-red-500">{{ form.errors.birthdate }}</div>

        <label class="after:ml-1 after:text-red-500 after:content-['*']">Report subject</label>
        <input type="text" v-model="form.report_subject" maxlength="255" @input="form.clearErrors('report_subject')"
               autocomplete="off" required
               class="border rounded-md w-full px-3 py-2">
        <div v-if="form.errors.report_subject" class="text-red-500">{{ form.errors.report_subject }}</div>

        <label class="after:ml-1 after:text-red-500 after:content-['*']">Country</label>
        <select required v-model="form.country" autocomplete="off" class="border rounded-md w-full px-3 py-2">
            <option v-for="country in countries" :value="country">
                {{ country }}
            </option>
        </select>
        <div v-if="form.errors.country" class="text-red-500">{{ form.errors.country }}</div>

        <label class="after:ml-1 after:text-red-500 after:content-['*']">Phone</label>
        <IntlTelInput v-model="form.phone" @change-number="form.clearErrors('phone')" :input-props="{
         required: true,
         autocomplete: 'off',
         placeholder: 'Enter your number',
         class: 'border rounded-md w-full px-3 py-2' }" :initial-country="initialCountry"
        />
        <div v-if="form.errors.phone" class="text-red-500">{{ form.errors.phone }}</div>

        <label class="after:ml-1 after:text-red-500 after:content-['*']">Email</label>
        <input type="email" v-model="form.email" maxlength="255" @input="form.clearErrors('email')" autocomplete="off"
               required class="border rounded-md w-full px-3 py-2">
        <div v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</div>

        <button type="submit" :disabled="form.processing" id="stepOneBtn"
                class="border rounded-md w-full px-3 py-2 hover:bg-gray-300">Next
        </button>
    </form>
</template>

