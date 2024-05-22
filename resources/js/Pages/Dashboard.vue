<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import User from '@/Pages/Components/User.vue';


defineProps({
    users: String
})

const alerts = (message) => {
    Swal.fire({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        icon: "success",
        title: message,
        timer: 1500,
    })
}
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <User :users="users" @alerts="alerts"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
