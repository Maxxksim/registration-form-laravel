<script setup>
import FlatPickr from "vue-flatpickr-component";
import 'flatpickr/dist/flatpickr.css';
import IntlTelInput from "@intl-tel-input/vue/with-utils";

const flatPickerConfig = {
    maxDate: 'today',
    dateFormat: 'Y-m-d',
}

const props = defineProps({
    members: Object
});

</script>

<template>
    <div>
        <div>
            <label for="first name">First Name</label>
            <input type="text" required class="border rounded-md w-full px-3 py-2">
        </div>

        <div>
            <label for="last name">Last Name</label>
            <input type="text" required class="border rounded-md w-full px-3 py-2">
        </div>

        <div>
            <FlatPickr required :config="flatPickerConfig" class="border rounded-md w-full px-3 py-2"/>
        </div>

        <div>
            <label for="report subject">Report subject</label>
            <input type="text" required class="border rounded-md w-full px-3 py-2">
        </div>

        <div><label for="country"></label>
            <select required class="border rounded-md w-full px-3 py-2">
                <option v-for="country in countries" :value="country">
                    {{ country }}
                </option>
            </select>
        </div>

        <div>
            <label for="phone">Phone</label>
            <IntlTelInput :input-props="{ class: 'border rounded-md w-full px-3 py-2' }"/>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" required class="border rounded-md w-full px-3 py-2">
        </div>

        <div>
            <label for="company">Company</label>
            <input type="text" required class="border rounded-md w-full px-3 py-2">
        </div>

        <div>
            <label for="position">Position</label>
            <input type="text" required class="border rounded-md w-full px-3 py-2">
        </div>

        <div>
            <label for="about me">About me</label>
            <textarea type="text" required class="border rounded-md w-full px-3 py-2"></textarea>
        </div>

        <div>
            <label for="photo">Photo</label>
            <img :src="`${member.photo_url}`"
                 alt="Photo"
                 class="w-20 h-20 rounded-md">
        </div>
    </div>
</template>

