<script setup>
import { Link } from '@inertiajs/vue3'
import logo from '../../assets/u-residence-logo.png'

defineProps({
    userName: {
        type: String,
        default: 'Dennis',
    },
})
</script>

<template>
    <nav class="border-b border-[#dde6df] bg-white shadow-sm">
        <div class="flex items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 lg:hidden">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#7f9d8b]">
                    <img :src="logo" alt="Logo" class="h-6 w-6 object-contain" />
                </div>
                <span class="text-sm font-semibold tracking-[0.14em] text-[#556b60]">U Residence</span>
            </div>

            <div class="ml-auto flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-medium text-[#556b60]">{{ userName }}</p>
                </div>

                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#d8c6a7] text-xs font-semibold text-[#556b60]">
                    {{ userName?.charAt(0) || 'U' }}
                </div>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="rounded-md bg-[#7f9d8b] px-3 py-2 text-sm font-medium text-white transition hover:bg-[#6f8f7f]"
                >
                    Logout
                </Link>
            </div>
        </div>
    </nav>
</template>