<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";

import Modal from '@/Components/Modal.vue';
const props=defineProps({
    show:Boolean,
    roleName:Object
})
const emit=defineEmits(["close"]);
</script>

<template>
<section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')" :maxWidth="'2xl'">
            <div class="p-6 text-black-900 dark:text-black-200">
                <h2 class="text-lg font-medium">
                   permission 
                </h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    all_permission role
                    <b>{{ props.roleName?.name }}</b>
                </p>
                <div class="my-6 grid grid-cols-2 sm:grid-cols-3">
                    <div
                        v-for="(permission, index) in props.roleName?.permissions"
                        :key="index"
                        class="flex justify-between w-full px-4 py-2"
                    >
                        {{ ++index + ". " + permission.name }}
                    </div>
                </div>
                <div class="mt-6 flex justify-end  cursor-pointer">
                    <SecondaryButton @click="emit('close')">
                        close
                    </SecondaryButton>
                </div>
            </div>
        </Modal>
    </section>
</template>