<script setup>
import { ref, watch } from 'vue';
import { ElMessageBox } from 'element-plus'
import { router, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    users: String
})

const emit = defineEmits(['alerts'])
const search = ref('');

watch(search, (value) => {
    router.get('user', { search: value}, {
        replace: true,
        preserveState: true,

    });
})

const form = useForm({
    name: '',
    email: '',
    last_name: '',
    phone: '',
    password: '',
})

const addUser = () => {
    form.post('/user', {
        preserveScroll: true,
        onSuccess: (page) => {
            emit('alerts', page.props.flash.success)
            form.reset()
            dialogVisible.value = false;
        }
    })
}

const dialogVisible = ref(false)
const editAction = ref(false)
const createAction = ref(false)
const id = ref()

const createModal = () => {
    dialogVisible.value = true;
    createAction.value = true;
    editAction.value = false;
    form.clearErrors()
    form.reset()
}

const editModal = (user) => {
    form.reset()
    dialogVisible.value = true;
    editAction.value = true;
    createAction.value = false;
    form.clearErrors()

    id.value = user.id
    form.name = user.name
    form.last_name = user.last_name
    form.email = user.email
    form.phone = user.phone
}

const update = () => {
    form.put('/user/' + id.value, {
        preserveScroll: true,
        onSuccess: (page) => {
            emit('alerts', page.props.flash.success)
            form.reset()
            dialogVisible.value = false;
        }
    })
}

const handleClose = (done) => {
    ElMessageBox.confirm('Are you sure to close this dialog?')
        .then(() => {
            done()
            resetForm()
        })
}

const deleted = async (user) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('users.destroy', user.id), {
                onSuccess: (page) => {
                    emit('alerts', page.props.flash.success)
                }
            })
        }
    });
}

</script>
<template>
    <el-dialog v-model="dialogVisible" :title="createAction ? 'REGISTRAR USUARIO' : 'EDITAR USUARIO'" width="700"
        :before-close="handleClose">
        <form class="p-4" id="formProduct" @submit.prevent="createAction ? addUser() : update()">
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" v-model="form.name"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " />
                    <label for="floating_first_name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First
                        name</label>
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" v-model="form.last_name"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " />
                    <label for="floating_last_name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                        name</label>
                    <InputError class="mt-2" :message="form.errors.last_name" />
                </div>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="email" v-model="form.email"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " />
                <label for="floating_email"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                    address</label>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="password" v-model="form.password"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " />
                <label for="floating_password"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="tel" v-model="form.phone"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " />
                    <label for="floating_phone"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone
                        number (123-456-7890)</label>
                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>
            </div>
        </form>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="primary" native-type="submit" form="formProduct">
                    Confirm
                </el-button>
            </div>
        </template>
    </el-dialog>
            <!-- Start coding here -->
            <div class="bg-white  relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fa-solid fa-magnifying-glass w-5 h-5 text-gray-500 "></i>
                                   
                                </div>
                                <input type="text" v-model="search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2"
                                    placeholder="Search" >
                            </div>
                        </div>
                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <i @click="createModal()" class="fa-regular fa-square-plus text-3xl cursor-pointer text-orange-500 hover:text-orange-600"></i>
                        
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                            <tr>
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="px-4 py-3">NAME</th>
                                <th scope="col" class="px-4 py-3">LAST NAME</th>
                                <th scope="col" class="px-4 py-3">EMAIL</th>
                                <th scope="col" class="px-4 py-3">PHONE</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data" :key="user.id" class="border-b ">
                                <td class="px-4 py-3">{{ user.id }}</td>
                                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">{{
                                    user.name }}</th>
                                <td class="px-4 py-3">{{ user.last_name }}</td>
                                <td class="px-4 py-3">{{ user.email }}</td>
                                <td class="px-4 py-3">{{ user.phone }}</td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button :id="`apple-imac-27-dropdown-button-${user.id}`"
                                        :data-dropdown-toggle="`apple-imac-27-dropdown-${user.id}`"
                                        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                        <i class="fa-solid fa-ellipsis text-xl text-orange-500 hover:text-orange-600"></i>
                                        
                                    </button>
                                    <div :id="`apple-imac-27-dropdown-${user.id}`"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="`apple-imac-27-dropdown-button-${user.id}`">
                                            <li class="cursor-pointer">
                                                <a @click="editModal(user)"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <a @click="deleted(user)"
                                                class="cursor-pointer block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :data="users" :page="5"/>
                </div>
            </div>
</template>