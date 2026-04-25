<script setup>
import AppSidebar from '@/Components/AppSidebar.vue'
import AppTopbar from '@/Components/AppTopbar.vue'
import AppFooter from '@/Components/AppFooter.vue'

defineProps({
    title: {
        type: String,
        default: '',
    },
    activeMenu: {
        type: String,
        default: '',
    },
    userName: {
        type: String,
        default: 'Dennis',
    },
})
</script>

<template>
    <div class="min-h-screen bg-[#eef3ef] text-[#556b60]">
        <div class="flex min-h-screen">
            <AppSidebar :active-menu="activeMenu" />

            <div class="flex min-h-screen flex-1 flex-col">
                <AppTopbar :user-name="userName" />

                <main class="flex-1 px-4 py-5 sm:px-6 lg:px-8">
                    <h1 v-if="title" class="mb-5 text-[30px] font-medium text-[#5f7067]">
                        {{ title }}
                    </h1>

                    <slot />
                </main>

                <AppFooter />
            </div>
        </div>
    </div>
</template>