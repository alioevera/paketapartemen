<script setup>
import { Link } from '@inertiajs/vue3'
import logo from '../../assets/u-residence-logo.png'
</script>

<template>
    <aside class="hidden w-[260px] flex-col bg-gradient-to-b from-[#7f9d8b] via-[#6f8f7f] to-[#5f7d6e] text-white lg:flex">
        <div class="flex items-center gap-3 border-b border-white/10 px-5 py-5">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/15">
                <img :src="logo" alt="Logo" class="h-7 w-7 object-contain" />
            </div>
            <div class="sidebar-brand-text mx-1 text-sm font-bold tracking-[0.14em]">
                U Residence
            </div>
        </div>

        <hr class="border-white/10" />

        <div class="space-y-2 px-4 py-4">
            <Link
                :href="route('dashboard')"
                class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-white/80 transition-all duration-200 hover:-translate-y-0.5 hover:bg-white/14 hover:text-white hover:shadow-[0_8px_20px_rgba(0,0,0,0.08)]"
            >
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white/90 transition-all duration-200 group-hover:bg-white/20">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10zm10 8h8V3h-8v18zM3 21h8v-6H3v6z" />
                    </svg>
                </div>
                <span class="font-medium">Dashboard</span>
            </Link>

            <Link
                :href="route('reception.index')"
                class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-white/80 transition-all duration-200 hover:-translate-y-0.5 hover:bg-white/14 hover:text-white hover:shadow-[0_8px_20px_rgba(0,0,0,0.08)]"
            >
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white/90 transition-all duration-200 group-hover:bg-white/20">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75a17.933 17.933 0 0 1-7.5-1.632Z" />
                    </svg>
                </div>
                <span class="font-medium">Data Resepsionis</span>
            </Link>

            <Link
                :href="route('tower.index')"
                class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-white/80 transition-all duration-200 hover:-translate-y-0.5 hover:bg-white/14 hover:text-white hover:shadow-[0_8px_20px_rgba(0,0,0,0.08)]"
            >
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white/90 transition-all duration-200 group-hover:bg-white/20">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M5.25 21V7.5l6.75-3 6.75 3V21M9 9.75h.008v.008H9V9.75Zm0 3h.008v.008H9v-.008Zm0 3h.008v.008H9v-.008Zm6-6h.008v.008H15V9.75Zm0 3h.008v.008H15v-.008Zm0 3h.008v.008H15v-.008Z" />
                    </svg>
                </div>
                <span class="font-medium">Data Tower</span>
            </Link>

            <Link
                :href="route('penghuni.index')"
                class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-white/80 transition-all duration-200 hover:-translate-y-0.5 hover:bg-white/14 hover:text-white hover:shadow-[0_8px_20px_rgba(0,0,0,0.08)]"
            >
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white/90 transition-all duration-200 group-hover:bg-white/20">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 0 1 2.121 0L22.5 12M4.5 9.75V19.5A1.5 1.5 0 0 0 6 21h12a1.5 1.5 0 0 0 1.5-1.5V9.75" />
                    </svg>
                </div>
                <span class="font-medium">Data Penghuni</span>
            </Link>

            <Link
                :href="route('expedisi.index')"
                class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-white/80 transition-all duration-200 hover:-translate-y-0.5 hover:bg-white/14 hover:text-white hover:shadow-[0_8px_20px_rgba(0,0,0,0.08)]"
            >
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white/90 transition-all duration-200 group-hover:bg-white/20">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17h6m-6-4h6m3 8H6a2.25 2.25 0 0 1-2.25-2.25V7.5A2.25 2.25 0 0 1 6 5.25h3.879a1.5 1.5 0 0 0 1.06-.44l.621-.62a1.5 1.5 0 0 1 1.06-.44H18A2.25 2.25 0 0 1 20.25 6v12.75A2.25 2.25 0 0 1 18 21Z" />
                    </svg>
                </div>
                <span class="font-medium">Data Expedisi</span>
            </Link>

            <Link
                :href="route('lihat-paket.index')"
                class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-white/80 transition-all duration-200 hover:-translate-y-0.5 hover:bg-white/14 hover:text-white hover:shadow-[0_8px_20px_rgba(0,0,0,0.08)]"
            >
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white/90 transition-all duration-200 group-hover:bg-white/20">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25V18A2.25 2.25 0 0 1 18.75 20.25H5.25A2.25 2.25 0 0 1 3 18V8.25m18 0-7.5 4.5-1.5.9-1.5-.9L3 8.25m18 0L13.06 3.98a2.25 2.25 0 0 0-2.12 0L3 8.25" />
                    </svg>
                </div>
                <span class="font-medium">Data Paket</span>
            </Link>

            <Link
                :href="route('paket-masuk.create')"
                class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-white/80 transition-all duration-200 hover:-translate-y-0.5 hover:bg-white/14 hover:text-white hover:shadow-[0_8px_20px_rgba(0,0,0,0.08)]"
            >
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white/90 transition-all duration-200 group-hover:bg-white/20">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <span class="font-medium">Tambah Paket</span>
            </Link>
        </div>

        <div class="mt-auto px-5 pb-6">
            <div class="flex justify-center">
                <button class="rounded-full bg-white/12 px-4 py-2 text-sm transition hover:bg-white/20">
                    ‹
                </button>
            </div>
        </div>
    </aside>
</template>