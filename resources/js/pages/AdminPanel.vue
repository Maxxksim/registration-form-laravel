<script setup>
import {InfiniteScroll, router} from "@inertiajs/vue3";
import AdminPanelEditMember from "@/components/AdminPanelEditMember.vue";
import {ref, watchEffect} from "vue";

const props = defineProps({
    members: Object,
    countries: Object
});

const options = {preserveScroll: true}

const isEditing = ref(false);
const editingMember = ref(null);

function switchVisibility(member) {
    router.patch(`/admin/members/${member.id}/visibility`, {
        is_visible: !member.is_visible
    }, options);
}

function deleteMember(member) {
    router.delete(`/admin/members/${member.id}`, options);
}

function editMember(member) {
    isEditing.value = true;
    editingMember.value = member;

}

watchEffect(function () {
    if (isEditing.value) {
        document.body.classList.add('overflow-hidden')
    } else {
        document.body.classList.remove('overflow-hidden')
    }
})

</script>

<template>
    <div class="m-5"><h1 class="text-2xl font-bold mb-4 text-center">Admin panel</h1></div>
    <InfiniteScroll data="members">
        <div class="max-w-7xl mx-auto p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="member in members.data" :key="member.id"
                     class="flex flex-col bg-white border rounded-lg shadow-sm p-5 gap-3 wrap-break-word">
                    <div class="flex flex-col-2 gap-3 self-center">
                        <div class="w-20 self-center">
                            <img :src="`${member.photo_url}`"
                                 alt="Photo"
                                 class="w-20 h-20 rounded-md">
                        </div>

                        <div :class="member.is_visible ? 'bg-green-300' : 'bg-red-300'"
                             class="border rounded-md w-auto h-20 content-center text-center self-center p-5">
                            <span class="font-bold">Visibility status: </span><br/>
                            <span class="">{{ member.is_visible ? 'VISIBLE' : 'HIDDEN' }}</span>
                        </div>
                    </div>

                    <div>
                        <span class="font-bold">First name: </span>
                        <span>{{ member.first_name }}</span>
                    </div>

                    <div>
                        <span class="font-bold">Last name: </span>
                        <span>{{ member.last_name }}</span>
                    </div>

                    <div>
                        <span class="font-bold">Birthdate: </span>
                        <span>{{ member.birthdate }}</span>
                    </div>

                    <div>
                        <span class="font-bold">Report subject: </span>
                        <span>{{ member.report_subject }}</span>
                    </div>

                    <div>
                        <span class="font-bold">Country: </span>
                        <span>{{ member.country }}</span>
                    </div>

                    <div>
                        <span class="font-bold">Phone: </span>
                        <span>{{ member.phone }}</span>
                    </div>

                    <div>
                        <span class="font-bold">Email: </span>
                        <span>{{ member.email }}</span>
                    </div>

                    <div>
                        <span class="font-bold">Company: </span>
                        <span>{{ member.company || '—' }}</span>
                    </div>

                    <div>
                        <span class="font-bold">Position: </span>
                        <span>{{ member.position || '—' }}</span>
                    </div>

                    <div>
                        <span class="font-bold">About me: </span>
                        <span>{{ member.about_me || '—' }}</span>
                    </div>

                    <div class="flex flex-col-3 gap-1 mt-auto text-xs">
                        <button @click="switchVisibility(member)"
                                class="border rounded-md w-100 px-3 py-2 bg-yellow-300 hover:bg-yellow-50">Switch
                            visibility
                        </button>
                        <button @click="editMember(member)"
                                class="border rounded-md w-100 px-3 py-2 bg-blue-300 hover:bg-blue-50">Edit
                        </button>
                        <button @click="deleteMember(member)"
                                class="border rounded-md w-100 px-3 py-2 bg-red-300 hover:bg-red-50">Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </InfiniteScroll>
    <AdminPanelEditMember v-if="isEditing" :member="editingMember" :countries="countries" @cancel="isEditing=false"/>
</template>



