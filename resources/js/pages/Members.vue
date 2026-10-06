<script setup>

import {InfiniteScroll} from "@inertiajs/vue3";

const props = defineProps({
    members: Object
});

</script>

<template>

    <div class="m-5"><h1 class="text-2xl font-bold mb-4 text-center">All members</h1></div>
    <div v-if="members.data.length === 0" class="m-5"><h2 class="mb-4 text-center">No members have registered yet.</h2></div>
    <InfiniteScroll data="members">
        <div class="mx-5 md:mx-10 text-center rounded-md">
            <div class="hidden md:grid grid-cols-4 rounded-md font-semibold mb-5">
                <div class="border m-2 rounded-md bg-white"><h2>Photo</h2></div>
                <div class="border m-2 rounded-md bg-white"><h2>Full name</h2></div>
                <div class="border m-2 rounded-md bg-white"><h2>Report subject</h2></div>
                <div class="border m-2 rounded-md bg-white"><h2>Email</h2></div>
            </div>
            <div>
                <div class="border rounded m-1 wrap-break-word">
                    <div v-for="member in members.data" :key="member.id"
                         class="grid grid-cols-1 rounded-md gap-3 bg-white md:rounded-none md:grid-cols-4 md:items-center  md:border-t-0">
                        <div class="flex items-center gap-3 p-5 md:justify-center">
                            <span class="font-semibold md:hidden">Photo:</span>
                            <img :src="member.photo_url"
                                 alt="Photo"
                                 class="w-20 h-20 rounded-md">
                        </div>

                        <div class="p-5">
                            <span class="font-semibold md:hidden">Full name:</span>
                            <span>{{ member.full_name }}</span>
                        </div>

                        <div>
                            <span class="font-semibold md:hidden">Report subject:</span>
                            <span>{{ member.report_subject }}</span>
                        </div>

                        <div>
                            <span class="font-semibold md:hidden">Email:</span>
                            <span> <a :href="`mailto:${member.email}`"
                                      class="text-blue-500 hover:underline">{{ member.email }}</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </InfiniteScroll>
</template>

