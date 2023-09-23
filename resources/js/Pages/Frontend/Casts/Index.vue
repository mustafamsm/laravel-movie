<script setup>
import { Head, Link } from '@inertiajs/vue3';
import FrontLayout from '@/Layouts/FrontLayout.vue';
 import MovieCard from '@/Components/MovieCard.vue';
import Pagination from '@/Components/Pagination.vue';
 defineProps({
       
    casts: {
            type: Array,
            required: true
        }
    
 })
</script>

<template>
    <Head title="Al Casts" />
<FrontLayout>
    <main class="max-w-6xl mx-auto mt-6 min-h-screen">
    
      <section
        class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded"
      >
        <div
          class="
            m-2
            p-2
            text-2xl
            font-bold
            text-indigo-600
            dark:text-indigo-300
          "
        >
          <h1>Casts</h1>
        </div>
        <div
          class="
            grid grid-cols-2
            sm:grid-cols-3
            md:grid-cols-4
            lg:grid-cols-6
            gap-4
            rounded
          "
        >
          <MovieCard v-for="cast in casts.data" :key="cast.id">
            <template #image>
              <Link :href="`/casts/${cast.slug}`">
                <div class="aspect-w-2 aspect-h-3">
                  <img
                    class="object-cover"
                    :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${cast.poster_path}`"
                  />
                </div>
                
                <div
                  class="
                    absolute
                    inset-0
                    z-10
                    bg-gradient-to-t
                    from-black
                    to-transparent
                  "
                ></div>
                
              </Link>
            </template>
            <Link :href="`/casts/${cast.slug}`">
              <div class="dark:text-white font-bold group-hover:text-blue-400">
                {{ cast.name }}
              </div>
            </Link>
          </MovieCard>
        </div>
        <div class="m-2 p-2 bg-gray-500 ">
            <Pagination :links="casts.links" />
        </div>
      </section>
    </main>
</FrontLayout>
    
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
