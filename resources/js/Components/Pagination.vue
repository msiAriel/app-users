<script setup>
import { router } from '@inertiajs/vue3';

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    page: {
        type: Number,
        required: true
    },
});

const pageTo = (url) => {
    router.get(url);
}     
</script>


<template>
    <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
        aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-500 ">
            Showing 
            <span class="font-semibold text-gray-900">{{   (page * data.current_page) - (page - 1) }}-{{ data.per_page * data.current_page  }}</span>
            of
            <span class="font-semibold text-gray-900">{{ data.total }}</span>
        </span>
        <ul v-if="data.total > page" class="inline-flex items-stretch -space-x-px">
            <li v-for="(link, index) in data.links" :key="index">
                <a @click="pageTo(link.url)"
                    :class="{ 'text-orange-600 bg-orange-50 border border-orange-300 hover:bg-orange-100 hover:text-orange-700': link.active }"
                    class="cursor-pointer flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700"
                    v-html="link.label"></a>
            </li>
        </ul>
    </nav>
</template>