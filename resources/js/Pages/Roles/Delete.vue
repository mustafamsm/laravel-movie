
<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useForm } from "@inertiajs/vue3";

const props=defineProps({
    show:Boolean,
    role:Object,
    title:String
})

const emit=defineEmits(['close'])

const form=useForm({
   
})

const destroy=()=>{
    form.delete(route('admin.roles.destroy',props.role?.id),{
        preserveScroll:true,
        onSuccess:()=>{
            emit('close')
            form.reset()
        },
        onError:()=>null,
        onFinish:()=>null,

    })
}
</script>

<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')" :maxWidth="'lg'">
            <form class="p-6" @submit.prevent="destroy">
                <h2
                    class="text-lg font-medium text-black-900 dark:text-black-100"
                >
                    delete  
                </h2>
                <p class="mt-1 text-sm text-black-800 dark:text-black-400">
                    Delete Confirm 
                    <b>{{ props.role?.name }}</b
                    >?
                </p>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton
                        :disabled="form.processing"
                        @click="emit('close')"
                    >
                       close 
                    </SecondaryButton>
                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="destroy"
                    >
                        {{
                            form.processing
                                ? 'delete' + "..."
                                : 'delete'
                        }}
                    </DangerButton>
                </div>
            </form>
        </Modal>
    </section>
</template>
