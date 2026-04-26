<script setup>
import { Link } from '@inertiajs/vue3'
import logo from '../../assets/u-residence-logo.png'

const props = defineProps({
    activeMenu: {
        type: String,
        default: '',
    },
    isCollapsed: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['toggle-sidebar'])

const menuItems = [
    {
        name: 'Dashboard',
        route: 'dashboard',
        icon: 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'
    },
    {
        name: 'Data Resepsionis',
        route: 'reception.index',
        icon: 'M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0zM1 21h15.1a5.5 5.5 0 01-14.1 0zM17 14.5a3.5 3.5 0 117 0V16h-7v-1.5z'
    },
    {
        name: 'Data Tower',
        route: 'tower.index',
        icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'
    },
    {
        name: 'Data Penghuni',
        route: 'penghuni.index',
        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
    },
    {
        name: 'Data Expedisi',
        route: 'expedisi.index',
        icon: 'M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0'
    },
    {
        name: 'Data Paket',
        route: 'lihat-paket.index',
        icon: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'
    },
    {
        name: 'Tambah Paket',
        route: 'paket-masuk.create',
        icon: 'M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z'
    },
]
</script>

<template>
    <aside
        :class="[
            'fixed left-0 top-0 z-40 hidden h-screen flex-col bg-gradient-to-b from-[#7f9d8b] via-[#6f8f7f] to-[#5f7d6e] text-white shadow-2xl transition-all duration-500 ease-in-out lg:flex',
            isCollapsed ? 'w-[90px]' : 'w-[280px]'
        ]"
    >
        <div class="flex items-center gap-4 overflow-hidden px-6 py-8 shrink-0">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/15 shadow-inner">
                <img :src="logo" alt="Logo" class="h-6 w-6 object-contain" />
            </div>

            <div v-show="!isCollapsed" class="whitespace-nowrap transition-all duration-300">
                <h1 class="text-xs font-black uppercase leading-none tracking-[0.3em]">
                    U Residence
                </h1>
                <p class="mt-1 text-[10px] font-medium tracking-wider opacity-50">
                    MANAGEMENT
                </p>
            </div>
        </div>

        <div class="flex-1 overflow-hidden px-4 py-3">
            <div class="space-y-2">
                <Link
                    v-for="item in menuItems"
                    :key="item.route"
                    :href="route(item.route)"
                    :class="[
                        'group relative flex items-center gap-4 overflow-hidden rounded-xl px-3 py-3.5 text-sm transition-all duration-300',
                        route().current(item.route + '*')
                            ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/20'
                            : 'text-white/60 hover:bg-white/5 hover:text-white'
                    ]"
                >
                    <div
                        v-if="route().current(item.route + '*')"
                        class="absolute bottom-3 left-0 top-3 w-1 rounded-r-full bg-white shadow-[0_0_12px_rgba(255,255,255,0.8)]"
                    ></div>

                    <div
                        :class="[
                            'flex h-9 w-9 shrink-0 items-center justify-center rounded-lg transition-all duration-500',
                            route().current(item.route + '*')
                                ? 'rotate-[360deg] bg-white text-[#6f8f7f] shadow-lg'
                                : 'bg-white/5 group-hover:scale-110 group-hover:bg-white/10'
                        ]"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" :d="item.icon" />
                        </svg>
                    </div>

                    <span
                        v-show="!isCollapsed"
                        :class="[
                            'whitespace-nowrap tracking-wide transition-all duration-300',
                            route().current(item.route + '*') ? 'font-bold' : 'font-medium'
                        ]"
                    >
                        {{ item.name }}
                    </span>
                </Link>

                <button
                    @click="emit('toggle-sidebar')"
                    class="mt-1 flex w-full items-center justify-center py-3 text-white/60 transition-all duration-300 hover:scale-110 hover:text-white"
                >
                    <svg
                        class="h-5 w-5 transition-transform duration-500"
                        :class="isCollapsed ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </aside>
</template>