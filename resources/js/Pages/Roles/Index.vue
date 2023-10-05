<template>
  <AdminLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Roles Index
      </h2>
    </template>

    <div class="py-12">

      <div class="rounded-lg overflow-hidden w-fit">
        <Edit :show="editOpen" @close="editOpen = false" :role="roleName" :permissions="props.permissions" title="Edit" />
        <Create :show="createOpen" @close="createOpen=false" :permissions="props.permissions"  />
        <Permission :show="permissionOpen" @close="permissionOpen = false" :roleName="roleName" title="test title" />
        <Delete :show="deleteOpen" @close="deleteOpen=false" :role="roleName" title="delete"/>
      </div>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <section class="container mx-auto p-6 font-mono">
          <div class="w-full flex mb-4 p-2 justify-end">
            <PrimaryButton   v-show="can(['create roles'])"
            class="rounded-none"
            @click="createOpen = true"
            >
            Create Role
            </PrimaryButton>
          </div>

          <div class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg">
            <div class="p-2 m-2">
              <div class="flex justify-between">
                <div class="flex-1">
                  <div class="relative">
                    <div class="absolute flex items-center ml-2 h-full">
                      <svg class="w-4 h-4 fill-current text-primary-gray-dark" viewBox="0 0 16 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M15.8898 15.0493L11.8588 11.0182C11.7869 10.9463 11.6932 10.9088 11.5932 10.9088H11.2713C12.3431 9.74952 12.9994 8.20272 12.9994 6.49968C12.9994 2.90923 10.0901 0 6.49968 0C2.90923 0 0 2.90923 0 6.49968C0 10.0901 2.90923 12.9994 6.49968 12.9994C8.20272 12.9994 9.74952 12.3431 10.9088 11.2744V11.5932C10.9088 11.6932 10.9495 11.7869 11.0182 11.8588L15.0493 15.8898C15.1961 16.0367 15.4336 16.0367 15.5805 15.8898L15.8898 15.5805C16.0367 15.4336 16.0367 15.1961 15.8898 15.0493ZM6.49968 11.9994C3.45921 11.9994 0.999951 9.54016 0.999951 6.49968C0.999951 3.45921 3.45921 0.999951 6.49968 0.999951C9.54016 0.999951 11.9994 3.45921 11.9994 6.49968C11.9994 9.54016 9.54016 11.9994 6.49968 11.9994Z">
                        </path>
                      </svg>
                    </div>

                    <input v-model="search" type="text" placeholder="Search by title" class="
                        px-8
                        py-3
                        w-full
                        md:w-2/6
                        rounded-md
                        bg-gray-100
                        border-transparent
                        focus:border-gray-500 focus:bg-white focus:ring-0
                        text-sm
                      " />
                  </div>
                </div>
                <div class="flex">
                  <select v-model="perPage" @change="getRoles" class="
                      px-4
                      py-3
                      w-full
                      rounded-md
                      bg-gray-100
                      border-transparent
                      focus:border-gray-500 focus:bg-white focus:ring-0
                      text-sm
                    ">
                    <option value="5">5 Per Page</option>
                    <option value="10">10 Per Page</option>
                    <option value="15">15 Per Page</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="w-full overflow-x-auto">
              <table class="w-full">
                <thead>
                  <tr class="
                      text-md
                      font-semibold
                      tracking-wide
                      text-left text-gray-900
                      bg-gray-100
                      uppercase
                      border-b border-gray-600
                    ">
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Permissions </th>
                    <th class="px-4 py-3">Manage</th>
                  </tr>
                </thead>
                <tbody class="bg-white">
                  <tr v-for="role in roles.data" :key="role.id" class="text-gray-700">
                    <td class="px-4 py-3 border">{{ role.name }}</td>


                    <td class="px-4 py-3 text-ms font-semibold border cursor-pointer"
                      v-if="role.permissions.length == props.permissions.length"
                      @click="(permissionOpen = true), (roleName = role)">
                      All Permission

                    </td>

                    <td class="px-4 py-3 text-ms font-semibold border cursor-pointer"
                      v-else-if="role.permissions.length != 0" @click="(permissionOpen = true), (roleName = role)">
                      {{ role.permissions.length }}
                      Permission

                    </td>
                    <td v-else class="whitespace-nowrap py-4 px-2 sm:py-3 cursor-pointer ">
                      no permission
                    </td>

                    <td class="px-4 py-3 text-sm border">
                      <div class="flex justify-around">
                        <InfoButton v-if="can(['edit roles'])" type="button" @click="(editOpen = true), (roleName = role)"
                          class="inline-flex items-center px-2 py-1.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150">
                          Edit
                        </InfoButton>
                        <DangerButton 
                        type="button"
                          class="
                          px-2 py-1.5 rounded-none
                          "
                          @click="(deleteOpen = true), (roleName = role)"
                          >
                        Delete
                        </DangerButton>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="m-2 p-2">
                <Pagination :links="roles.links" />
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </AdminLayout>
</template>


<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import Edit from '@/Pages/Roles/Edit.vue'
import InfoButton from "@/Components/InfoButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Create from '@/Pages/Roles/Create.vue'
import { router } from '@inertiajs/vue3'
import Permission from '@/Pages/Roles/Permission.vue';
import Delete from '@/Pages/Roles/Delete.vue'

const props = defineProps({
  roles: Object,
  filters: Object,
  permissions: Object
})
const search = ref(props.filters.search)
const perPage = ref(5)

const roleName = ref(null);
const permissionOpen = ref(false);
const editOpen = ref(false);
const createOpen=ref(false);
const deleteOpen=ref(false);
watch(search, value => {
  router.get(`/admin/roles`, { search: value, perPage: perPage.value },
    {
      preserveState: true,
      preserveScroll: true,
      replace: true
    })

})

function getRoles() {
  router.get(`/admin/roles`, { perPage: perPage.value, search: search.value },
    {
      preserveState: true,
      preserveScroll: true,
      replace: true
    })
}
</script>