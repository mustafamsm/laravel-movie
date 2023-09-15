<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Episode Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto ">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2 ">
                        <Link :href="route('admin.episodes.index', [tvShow.id, season.id])" class="
                            bg-green-500
                            hover:bg-green-700
                            text-white
                            px-4
                            py-2
                            rounded-lg
                          ">
                        Episode Index
                        </Link>
                    </div>

                    <div class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg">


                        <div class="w-full mb-8 p-6 sm:max-w-md overflow-x-auto">
                            <form @submit.prevent="submitEpisode">
                                <div>
                                    <InputLabel for="name" value="Name" />
                                    <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required
                                        autofocus autocomplete="name" />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>
                                <div>
                                    <InputLabel for="overview" value="Overview" />
                                    <TextInput id="overview" v-model="form.overview" type="text" class="mt-1 block w-full"
                                        required autofocus autocomplete="overview" />
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


 import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Checkbox from "@/Components/Checkbox.vue";

import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    tvShow: Object,
    season: Object,
    episode: Object,
})


const form = useForm({
    name: props.episode.name,
    overview: props.episode.overview,
    is_public: props.episode.is_public ? true : false,

})

function submitEpisode() {
    form.put(
        `/admin/tv-shows/${props.tvShow.id}/seasons/${props.season.id}/episodes/${props.episode.id}`
    );
}

</script>
