<script setup>

import {Link} from "@inertiajs/vue3";
let props=defineProps({
    link:{
        type:String,
        required:true

    }
})
</script>

<template>
    <Link
        :href="link"
        class="
                            bg-green-500
                            hover:bg-green-700
                            text-white
                            px-4
                            py-2
                            rounded-lg
                          "

    >
        <slot></slot>
    </Link>
</template>

<style scoped>

</style>
