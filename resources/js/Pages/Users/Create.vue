<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { watchEffect, ref } from "vue";
import SelectInput from "@/Components/SelectInput.vue";
const props = defineProps({
    show: Boolean,
    title: String,
    roles: Object,
    
})



const emit = defineEmits(['close']);

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "",
})

const create = () => {
    form.post(route('admin.users.store'), {
        preserveScroll: true,
        onSuccess: () => {
            emit("close");
            form.reset();

        },
        onError: () => null,
        OnFinish: () => null,
    });
};

watchEffect(() => {
    //when open the modal fill the inputs
    if (props.show) {
        form.errors = {};
      
    }
  
    
})

const roles = props.roles?.map((role) => ({
    label: role.name,
    value: role.name,
}));
</script>

<template>
    <seaction class="space-y-6">
        <Modal :show="props.show" @clode="emit('close')" >
            <form @submit.prevent="create" class="p-6">
                <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                    Edit {{ props.title }}
                </h2>
                <div class="my-6 space-y-4">
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                            placeholder="name" :error="form.errors.name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel for="email" value="email" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            placeholder="email"
                            :error="form.errors.email"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div>
                        <InputLabel for="password" value="password" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            placeholder="password"
                            :error="form.errors.password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                    <div>
                        <InputLabel for="password" value="password" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            placeholder="password"
                            :error="form.errors.password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                    <div>
                        <InputLabel
                            for="password_confirmation"
                            value="password_confirmation"
                        />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            placeholder="password_confirmation"
                            :error="form.errors.password_confirmation"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password_confirmation"
                        />
                    </div>
                    <div>
                        <InputLabel for="role" value="role"/>
                        <SelectInput
                        id="role"
                        class="mt-1 block w-full"
                        v-model="form.role"
                        required
                        :dataSet="roles"
                        
                        ></SelectInput>
                        <InputError class="mt-2" :message="form.errors.role" />
                    </div>
                   
                </div>
                <div class="flex justify-end">
                    <SecondaryButton :disabled="form.processing" @click="emit('close')">
                        close
                    </SecondaryButton>
                    <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        type="submit">
                        {{
                            form.processing
                            ? "button save" + "..."
                            : "button save"
                        }}
                    </PrimaryButton>
                </div>
            </form>

        </Modal>
    </seaction>
</template>