<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { watchEffect, ref } from "vue";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
  show: Boolean,
  title: String,
  role: Object,
  permissions: Object,
})

const multipleSelect = ref(false);

const emit = defineEmits(['close']);

const form = useForm({
  name: "",
  permissions: [],
})

const update = () => {
  form.put(route('admin.roles.update', props.role?.id), {
    preserveScroll: true,
    onSuccess: () => {
      emit("close");
      form.reset();
      multipleSelect.value = false;
    },
    onError: () => null,
    OnFinish: () => null,
  });
};

watchEffect(()=>{
  if(props.show){
    form.props={};
    form.name=props.role?.name;
    form.permissions=props.role.permissions?.map((d)=>d.id);
  }
  if(props.permissions.length==props.role?.permissions.length){
    multipleSelect.value=true;
  }else{
    multipleSelect.value=false;
  }
})
const selectAll = (event) => {
    if (event.target.checked === false) {
        form.permissions = [];
    } else {
        form.permissions = [];
        props.permissions.forEach((permission) => {
            form.permissions.push(permission.id);
        });
    }
};
const select = () => {
    if (props.permissions.length == form.permissions.length) {
        multipleSelect.value = true;
    } else {
        multipleSelect.value = false;
    }
};

</script>

<template>
  <seaction class="space-y-6">
    <Modal :show="props.show" @clode="emit('close')">
      <form @submit.prevent="update" class="p-6">
        <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
         Edit {{ props.title }}
        </h2>
        <div class="my-6 space-y-4">
                    <div>
                        <InputLabel for="name" value="role" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            placeholder="name"
                            :error="form.errors.name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel value="Permission" />
                        <InputError
                            class="mt-2"
                            :message="form.errors.permissions"
                        />
                        <div
                            class="flex justify-start items-center space-x-2 mt-2"
                        >
                            <Checkbox
                                id="permission-all"
                                v-model:checked="multipleSelect"
                                @change="selectAll"
                            />
                            <InputLabel
                                for="permission-all"
                                value="Check All"
                            />
                        </div>
                        <div
                            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 mt-2"
                        >
                            <div
                                class="flex items-center justify-start space-x-2"
                                v-for="(permission, index) in props.permissions"
                                :key="index"
                            >
                                <input
                                    @change="select"
                                    class="rounded dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-primary dark:text-primary shadow-sm focus:ring-primary/80 dark:focus:ring-primary dark:focus:ring-offset-slate-800 dark:checked:bg-primary dark:checked:border-primary"
                                    type="checkbox"
                                    :id="'permission_' + permission.id"
                                    :value="permission.id"
                                    v-model="form.permissions"
                                />
                                <InputLabel
                                    :for="'permission_' + permission.id"
                                    :value="permission.name"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <SecondaryButton
                        :disabled="form.processing"
                        @click="emit('close')"
                    >
                       close 
                    </SecondaryButton>
                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        type="submit"
                    >
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