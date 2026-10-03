<script setup>
import FlatPickr from "vue-flatpickr-component";
import 'flatpickr/dist/flatpickr.css';
import IntlTelInput from "@intl-tel-input/vue/with-utils";
import "intl-tel-input/styles";
import {useForm} from "@inertiajs/vue3";
import {computed, ref} from "vue";

const flatPickerConfig = {
    maxDate: 'today',
    dateFormat: 'Y-m-d',
};

const props = defineProps({
    member: Object,
    countries: Object
});

const photoInput = ref(null)
const emit = defineEmits(['cancel']);

const form = useForm({
    first_name: props.member.first_name,
    last_name: props.member.last_name,
    birthdate: props.member.birthdate,
    report_subject: props.member.report_subject,
    country: props.member.country,
    phone: props.member.phone,
    email: props.member.email,
    company: props.member.company ?? null,
    position: props.member.position ?? null,
    about_me: props.member.about_me ?? null,
    photo: null
});

const visibleBtn = computed(function () {
    if (form.photo) {
        return true;
    }
    return false;
});

function cancelPhoto() {
    form.photo = null;
    if (photoInput.value) {
        photoInput.value.value = ''
    }
}

function updateMember() {
    form.patch(`/admin/members/${props.member.id}`, {
        preserveScroll: 'errors',
        onSuccess: () => emit('cancel'),
    });
}

</script>

<template>
    <div class="fixed inset-0 bg-black/50 content-center overflow-y-auto">
        <form @submit.prevent="updateMember"
              class="max-w-xl mx-auto p-5 bg-white rounded-md gap-4">
            <div class="flex gap-4 flex-col md:flex-row">
                <div class="flex-1 min-w-0">
                    <div>
                        <label for="first name">First Name</label>
                        <input type="text" v-model="form.first_name" required
                               class="border rounded-md w-full px-3 py-2">
                        <div v-if="form.errors.first_name" class="text-red-500">{{ form.errors.first_name }}</div>
                    </div>

                    <div>
                        <label for="last name">Last Name</label>
                        <input type="text" v-model="form.last_name" required class="border rounded-md w-full px-3 py-2">
                        <div v-if="form.errors.last_name" class="text-red-500">{{ form.errors.last_name }}</div>
                    </div>

                    <div>
                        <label for="birthdate">Birthdate</label>
                        <FlatPickr v-model="form.birthdate" required :config="flatPickerConfig"
                                   class="border rounded-md w-full px-3 py-2"/>
                        <div v-if="form.errors.birthdate" class="text-red-500">{{ form.errors.birthdate }}</div>
                    </div>

                    <div>
                        <label for="report subject">Report subject</label>
                        <input type="text" v-model="form.report_subject" required
                               class="border rounded-md w-full px-3 py-2">
                        <div v-if="form.errors.report_subject" class="text-red-500">{{
                                form.errors.report_subject
                            }}
                        </div>
                    </div>

                    <div><label for="country">Country</label>
                        <select v-model="form.country" required class="border rounded-md w-full px-3 py-2">
                            <option v-for="country in countries" :value="country">
                                {{ country }}
                            </option>
                        </select>
                        <div v-if="form.errors.country" class="text-red-500">{{ form.errors.country }}</div>
                    </div>

                    <div>
                        <label for="phone" class="block">Phone</label>
                        <IntlTelInput v-model="form.phone"
                                      :input-props="{ class: 'border rounded-md w-full block px-3 py-2' }"/>
                        <div v-if="form.errors.phone" class="text-red-500">{{ form.errors.phone }}</div>
                    </div>

                    <div>
                        <label for="email" class="block">Email</label>
                        <input type="email" v-model="form.email" required class="border rounded-md w-full px-3 py-2">
                        <div v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</div>
                    </div>
                </div>

                <div class="flex-1 min-w-0">
                    <div>
                        <label for="company">Company</label>
                        <input type="text" v-model="form.company" required class="border rounded-md w-full px-3 py-2">
                        <div v-if="form.errors.company" class="text-red-500">{{ form.errors.company }}</div>
                    </div>

                    <div>
                        <label for="position">Position</label>
                        <input type="text" v-model="form.position"  class="border rounded-md w-full px-3 py-2">
                        <div v-if="form.errors.position" class="text-red-500">{{ form.errors.position }}</div>
                    </div>

                    <div>
                        <label for="about me">About me</label>
                        <textarea type="text" v-model="form.about_me"
                                  class="break-word border rounded-md w-full h-[111.5px] resize-y px-3 py-2"></textarea>
                        <div v-if="form.errors.about_me" class="text-red-500">{{ form.errors.about_me }}</div>
                    </div>

                    <div class="flex flex-col gap-4 items-center">

                        <div>
                            <label for="photo" class="text-start">Current photo</label>
                            <img :src="props.member.photo_url"
                                 alt="Photo"
                                 class="w-20 h-20 rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="upload new photo">To upload new photo:</label>
                            <div class="relative">

                                <input type="file" ref="photoInput" @input="form.photo = $event.target.files[0]"
                                       accept="image/png, image/jpeg, image/webp"
                                       class="border rounded-md w-full px-3 py-2 pr-12 hover:file:bg-gray-300">
                                <button v-if="visibleBtn" type="button" @click="cancelPhoto()"
                                        class="absolute right-0.5 rounded  px-3 py-2 hover:bg-gray-300">✕
                                </button>
                            </div>
                            <div v-if="form.errors.photo" class="text-red-500">{{ form.errors.photo }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center gap-4 mt-4">
                <button @click="emit('cancel')" class="border rounded-md w-full px-3 py-2 hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" :disabled="form.processing" class="border rounded-md w-full px-3 py-2 hover:bg-gray-300">Update
                </button>
            </div>
        </form>
    </div>
</template>

