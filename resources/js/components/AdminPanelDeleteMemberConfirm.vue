<script setup>
import {router} from '@inertiajs/vue3';


const props = defineProps({
    member: Object,
});

const emit = defineEmits(['show-component']);

function deleteMember(member) {
    router.delete(`/admin/members/${member.id}`, {
        preserveScroll: 'errors',
        onSuccess: () => emit('show-component'),
    });
}

</script>

<template>
        <div class="absolute inset-0 z-10 flex items-center justify-center rounded-lg backdrop-blur-[1px]">
            <div class="flex flex-col gap-3 p-4 rounded-md border bg-white/90 shadow-lg text-center text-sm">
                <span>Do you want to delete the member?</span>
                <div class="flex justify-center gap-2">
                    <div>
                        <button @click="emit('show-component')"
                                class="border rounded-md px-3 py-2 bg-green-500 hover:bg-green-300">
                            No, cancel
                        </button>
                    </div>
                    <div>
                        <button @click="deleteMember(props.member)"
                                class="border rounded-md px-3 py-2 bg-red-500 hover:bg-red-300">
                            Yes, delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
</template>
