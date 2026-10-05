<script setup>

import {computed} from "vue";
import {Link} from "@inertiajs/vue3"
import Map from "@/components/Map.vue";
import Error from "@/components/Error.vue";

const props = defineProps({
    sharingData: Object,
    countMembers: String
});

const sharingTwitterUrl = computed(() =>
    `https://x.com/intent/tweet?text=${encodeURIComponent(props.sharingData.text)}&url=${encodeURIComponent(props.sharingData.url)}`
);

const sharingFacebookUrl = computed(() =>
    `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(props.sharingData.url)}`
);

</script>

<template>
    <Error/>
    <div class="text-center">
        <Map></Map>
        <h1 class="text-2xl font-bold mb-6 ">
            Thanks
        </h1>

        <div class="mx-auto grid w-full max-w-xs grid-cols-2 gap-3 text-sm">
            <Link href="/members" class="text-blue-700 hover:underline">All members ({{ countMembers }})</Link>
            <Link href="/register/start" class="text-blue-700 hover:underline">Start over</Link>
            <a :href="sharingFacebookUrl" rel="noopener noreferrer"
               class="border rounded-md w-full p-3" target="_blank" type="button">Share to Facebook</a>
            <a :href="sharingTwitterUrl" rel="noopener noreferrer"
               class="border rounded-md w-full p-3" target="_blank" type="button">Share to Twitter</a>
        </div>
    </div>
</template>

