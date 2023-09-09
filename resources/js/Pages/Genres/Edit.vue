<template>
    <AdminLayout title="Dashboard">
        <template #header>
                Genre Edit
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto ">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2 ">
                        <Link
                            :href="route('admin.genres.index')"
                            class="
                            bg-green-500
                            hover:bg-green-700
                            text-white
                            px-4
                            py-2
                            rounded-lg
                          "

                        >
                            Genre Index
                        </Link>
                    </div>

                    <div
                        class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg"

                    >


                        <div class="w-full mb-8 p-6 sm:max-w-md overflow-x-auto">
                            <form @submit.prevent="submitGenre">
                                <div>
                                    <InputLabel for="title" value="Title" />
                                    <TextInput
                                        id="title"
                                        v-model="form.title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                        autofocus
                                        autocomplete="title"
                                    />
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>

                                <div class="flex items-center justify-end mt-4">


                                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Update
                                    </PrimaryButton>
                                </div>



                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </AdminLayout>
</template>


<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'


import {Link,useForm} from '@inertiajs/vue3'


import {router} from '@inertiajs/vue3'
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    genre: Object,

})


const form=useForm({
    title:props.genre.title,


})

function submitGenre(){
    form.put(route('admin.genres.update',props.genre.id),{

        // onSuccess:()=>router.push(route('admin.casts.index'))
    })
}

</script>
