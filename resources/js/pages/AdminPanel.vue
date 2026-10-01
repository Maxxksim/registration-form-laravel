<script setup>

const props = defineProps({
    members: Object
});

</script>

<template>

    <div class="m-5"><h1 class="text-2xl font-bold mb-4 text-center">Admin panel</h1></div>
    <div class="mx-5 md:mx-10 text-center rounded-md text-xs">
        <div class="hidden md:grid grid-cols-4 rounded-md font-semibold mb-5">
            <div class="border m-2 rounded-md bg-white"><h2>Photo</h2></div>
            <div class="border m-2 rounded-md bg-white"><h2>First name</h2></div>
            <div class="border m-2 rounded-md bg-white"><h2>Last name</h2></div>
            <div class="border m-2 rounded-md bg-white"><h2>Birthdate</h2></div>
            <div class="border m-2 rounded-md bg-white"><h2>Report subject</h2></div>
            <div class="border m-2 rounded-md bg-white"><h2>Country</h2></div>
            <div class="border m-2 rounded-md bg-white"><h2>Phone</h2></div>
            <div class="border m-2 rounded-md bg-white"><h2>Email</h2></div>
            <div class="border m-2 rounded-md bg-white"><h2>Company</h2></div>
            <div class="border m-2 rounded-md bg-white"><h2>Position</h2></div>
            <div class="border m-2 rounded-md bg-white"><h2>About me</h2></div>
            <div class="border m-2 rounded-md bg-white"><h2></h2></div>
        </div>
        <div class="flex flex-col gap-4 md:gap-0">
            <div>
                <div class="border rounded m-1 wrap-break-word">
                    <div v-for="member in members.data"
                         class="grid grid-cols-1 rounded-md gap-3 bg-white md:rounded-none md:grid-cols-4 md:items-center  md:border-t-0">
                        <div class="flex items-center gap-3 p-5 md:justify-center">
                            <span class="font-semibold md:hidden">Photo:</span>
                            <img :src="`${member.photo_url}`"
                                 alt="Photo"
                                 class="w-20 h-20 rounded-md">
                        </div>

                        <div>
                            <span class="font-semibold md:hidden">First name:</span>
                            <span>{{ member.first_name }}</span>
                        </div>

                        <div>
                            <span class="font-semibold md:hidden">Last name:</span>
                            <span>{{ member.last_name }}</span>
                        </div>

                        <div>
                            <span class="font-semibold md:hidden">Birthdate:</span>
                            <span>{{ member.birthdate }}</span>
                        </div>

                        <div>
                            <span class="font-semibold md:hidden">Report subject:</span>
                            <span>{{ member.report_subject }}</span>
                        </div>

                        <div>
                            <span class="font-semibold md:hidden">Country:</span>
                            <span>{{ member.country }}</span>
                        </div>

                        <div>
                            <span class="font-semibold md:hidden">Phone:</span>
                            <span>{{ member.phone }}</span>
                        </div>

                        <div>
                            <span class="font-semibold md:hidden">Email:</span>
                            <span>{{ member.email }}</span>
                        </div>

                        <div>
                            <span class="font-semibold md:hidden">Company:</span>
                            <span>{{ member.company }}</span>
                        </div>

                        <div>
                            <span class="font-semibold md:hidden">Position:</span>
                            <span>{{ member.position }}</span>
                        </div>

                        <div>
                            <span class="font-semibold md:hidden">About me:</span>
                            <span>{{ member.about_me }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



