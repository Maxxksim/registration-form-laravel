<script setup>
import {useForm} from "@inertiajs/vue3";

const form = useForm({
    username: null,
    password: null
});

</script>

<template>

    <div class="flex flex-row min-h-screen justify-center items-center">

        <form @submit.prevent="form.post('/admin/login')" class="flex flex-col gap-4 p-4">
            <div class="mb-3">
                <h1 class="text-2xl font-bold text-center">Login to Admin panel</h1>
            </div>
            <label>Username</label>
            <input type="text" maxlength="255" v-model="form.username" required
                   class="border rounded-md w-80 px-3 py-2" autocomplete="off">

            <label>Password</label>
            <input type="password" v-model="form.password" maxlength="255" required
                   class="border rounded-md w-80 px-3 py-2" autocomplete="new-password">

            <div v-if="form.errors.credentials" class="text-red-500">
                {{ form.errors.credentials }}
            </div>

            <button type="submit" :disabled="form.processing"
                    class="border rounded-md w-80 px-3 py-2 hover:bg-gray-300">Login
            </button>
        </form>
    </div>
</template>

