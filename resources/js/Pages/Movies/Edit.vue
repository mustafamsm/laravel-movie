<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movie Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto ">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2 ">
                        <Link :href="route('admin.movies.index')" class="
                            bg-green-500
                            hover:bg-green-700
                            text-white
                            px-4
                            py-2
                            rounded-lg
                          ">
                        Movie Index
                        </Link>
                    </div>

                    <div class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg">


                        <div class="w-full mb-8 p-6 sm:max-w-md overflow-x-auto">
                            <form @submit.prevent="submitMovie">
                                <div>
                                    <InputLabel for="title" value="Title" />
                                    <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full"
                                        required autofocus autocomplete="title" />
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>
                                <div>
                                    <InputLabel for="runtime" value="Runtime" />
                                    <TextInput id="runtime" v-model="form.runtime" type="text" class="mt-1 block w-full"
                                        required  autocomplete="runtime" />
                                    <InputError class="mt-2" :message="form.errors.runtime" />
                                </div>
                                <div>
                                    <InputLabel for="lang" value="Language" />
                                    <TextInput id="lang" v-model="form.lang" type="text" class="mt-1 block w-full" required
                                         autocomplete="lang" />
                                    <InputError class="mt-2" :message="form.errors.lang" />
                                </div>
                                <div>
                                    <InputLabel for="video_format" value="Format" />
                                    <TextInput id="video_format" v-model="form.video_format" type="text"
                                        class="mt-1 block w-full" required  autocomplete="video_format" />
                                    <InputError class="mt-2" :message="form.errors.video_format" />
                                </div>
                                <div>
                                    <InputLabel for="rating" value="Rating" />
                                    <TextInput id="rating" v-model="form.rating" type="text" class="mt-1 block w-full"
                                        required  autocomplete="rating" />
                                    <InputError class="mt-2" :message="form.errors.rating" />
                                </div>

                                <div>
                                    <InputLabel for="poster_path" value="Poster" />
                                    <TextInput id="poster_path" v-model="form.poster_path" type="text"
                                        class="mt-1 block w-full" required  autocomplete="name" />
                                    <InputError class="mt-2" :message="form.errors.poster_path" />
                                </div>
                                <div>
                                    <InputLabel for="backdrop_path" value="Backdrop" />
                                    <TextInput id="backdrop_path" v-model="form.backdrop_path" type="text" class="mt-1 block w-full"
                                        required  autocomplete="backdrop_path" />
                                    <InputError class="mt-2" :message="form.errors.backdrop_path" />
                                </div>
                                <div>
                                    <InputLabel for="overview" value="Overview" />
                                    <TextInput id="overview" v-model="form.overview" type="text" class="mt-1 block w-full"
                                        required  autocomplete="overview" />
                                    <InputError class="mt-2" :message="form.errors.overview" />
                                </div>
                                <div class="mt-4">
                                    <label class="flex items-center">
                                        <Checkbox name="is_public" v-model:checked="form.is_public" />
                                        <span class="ml-2 text-sm text-gray-600">Public</span>
                                    </label>
                                    <div class="text-sm text-red-400" v-if="form.errors.is_public">
                                        {{ form.errors.is_public }}
                                    </div>
                                </div>

                                <div class="flex items-center justify-end mt-4">


                                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
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


import { Link, useForm } from '@inertiajs/vue3'


import { router } from '@inertiajs/vue3'
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

import Checkbox from '@/Components/Checkbox.vue';

import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    movie: Object,

})


const form = useForm({
    title: props.movie.title,
    runtime: props.movie.runtime,
    lang: props.movie.lang,
    video_format: props.movie.video_format,
    rating: props.movie.rating,
    overview: props.movie.overview,
    backdrop_path: props.movie.backdrop_path,
    is_public: props.movie.is_public?true:false,
    poster_path: props.movie.poster_path

})

function submitMovie() {
    form.put(route('admin.movies.update', props.movie.id), {

    })
}

</script>
