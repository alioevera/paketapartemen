<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { reactive, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    paket: {
        type: Array,
        default: () => [],
    },
    authUser: {
        type: Object,
        default: () => ({}),
    },
})

const filters = reactive({
    search: '',
    tanggalMasuk: '',
})

const formatDate = (value) => {
    if (!value) return ''
    if (/^\d{4}-\d{2}-\d{2}$/.test(value)) {
        const [y, m, d] = value.split('-')
        return `${d}-${m}-${y}`
    }
    return value
}

const filteredPaket = computed(() => {
    return props.paket.filter((item) => {
        const nomorUnit = (item.nomor_unit || '').toLowerCase().trim()
        const search = filters.search.toLowerCase().trim()
        const tglMasuk = item.input_date || ''

        const matchSearch = !search || nomorUnit.includes(search)
        const matchMasuk = !filters.tanggalMasuk || filters.tanggalMasuk === tglMasuk

        return matchSearch && matchMasuk
    })
})

const resetFilter = () => {
    filters.search = ''
    filters.tanggalMasuk = ''
}
</script>

<template>
    <Head title="Lihat Paket Masuk" />

    <AppLayout
        title="Daftar Paket Masuk"
        active-menu="lihat-paket"
        :user-name="authUser?.user_name || 'User'"
    >
        <div class="w-full overflow-x-hidden">
            <section class="rounded-2xl bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-[#ebefec] px-4 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-[#556b60]">
                            Data Paket Masuk
                        </h2>
                        <p class="mt-1 text-sm text-[#8a9a91]">
                            Lihat seluruh data paket masuk berdasarkan input dari halaman tambah paket.
                        </p>
                    </div>

                    <Link
                        :href="route('paket-masuk.create')"
                        class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-4 py-2.5 text-sm font-semibold text-white shadow-[0_10px_20px_rgba(111,143,127,0.22)] transition hover:-translate-y-0.5"
                    >
                        + Tambah Paket
                    </Link>
                </div>

                <div class="px-4 py-5 sm:px-6">
                    <div
                        v-if="$page.props.flash?.success"
                        class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
                    >
                        {{ $page.props.flash.success }}
                    </div>

                    <div class="mb-5 grid gap-4 xl:grid-cols-[1.3fr_1fr_auto]">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                Cari Nomor Unit
                            </label>
                            <input
                                v-model="filters.search"
                                type="text"
                                placeholder="Ketik nomor unit..."
                                class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none transition focus:border-[#8aa293] focus:ring-2 focus:ring-[#edf3ef]"
                            />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                Tanggal Paket Masuk
                            </label>
                            <input
                                v-model="filters.tanggalMasuk"
                                type="date"
                                class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none transition focus:border-[#8aa293] focus:ring-2 focus:ring-[#edf3ef]"
                            />
                        </div>

                        <div class="flex items-end">
                            <button
                                type="button"
                                @click="resetFilter"
                                class="w-full rounded-xl bg-[#edf3ef] px-4 py-3 text-sm font-medium text-[#556b60] transition hover:bg-[#e2ebe4] xl:w-auto"
                            >
                                Reset Filter
                            </button>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[#e5ebe6] bg-[#fafcfb] p-3">
                        <div class="mb-3 flex items-center justify-between gap-3">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">
                                Tabel Paket
                            </p>
                            <p class="text-xs text-[#9aa8a1]">
                                Geser ke kanan bila layar kecil
                            </p>
                        </div>

                        <div class="table-scroll w-full overflow-x-auto overflow-y-hidden rounded-xl border border-[#e5ebe6] bg-white">
                            <table class="min-w-[980px] w-full border-separate border-spacing-0 text-sm text-[#5f7067]">
                                <thead>
                                    <tr class="bg-[#f5f7f6] text-left text-[#6b7d72]">
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Tanggal Masuk</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Jam Masuk</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Resepsionis</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Ekspedisi</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Unit</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Tower</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Nama Penghuni</th>
                                        <th class="whitespace-nowrap border-b border-[#e5ebe6] px-4 py-3 text-center font-semibold">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr
                                        v-for="p in filteredPaket"
                                        :key="p.paketin_id"
                                        class="hover:bg-[#fbfcfb]"
                                    >
                                        <td class="whitespace-nowrap border-b border-r border-[#eef2ef] px-4 py-4">
                                            {{ formatDate(p.input_date) }}
                                        </td>
                                        <td class="whitespace-nowrap border-b border-r border-[#eef2ef] px-4 py-4">
                                            {{ p.input_time }}
                                        </td>
                                        <td class="whitespace-nowrap border-b border-r border-[#eef2ef] px-4 py-4">
                                            {{ p.penerima_input }}
                                        </td>
                                        <td class="whitespace-nowrap border-b border-r border-[#eef2ef] px-4 py-4">
                                            {{ p.expedisi_name }}
                                        </td>
                                        <td class="whitespace-nowrap border-b border-r border-[#eef2ef] px-4 py-4 font-medium text-[#556b60]">
                                            {{ p.nomor_unit }}
                                        </td>
                                        <td class="whitespace-nowrap border-b border-r border-[#eef2ef] px-4 py-4">
                                            {{ p.tower_name }}
                                        </td>
                                        <td class="whitespace-nowrap border-b border-r border-[#eef2ef] px-4 py-4">
                                            {{ p.kepada }}
                                        </td>

                                        <td class="whitespace-nowrap border-b border-[#eef2ef] px-4 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <Link
                                                    :href="route('paket.show', p.paketin_id)"
                                                    class="rounded-lg bg-blue-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-blue-600"
                                                >
                                                    View 
                                                </Link>

                                                <Link
                                                    :href="route('paket.edit', p.paketin_id)"
                                                    class="rounded-lg bg-amber-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-amber-600"
                                                >
                                                    Edit
                                                </Link>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-if="!filteredPaket.length">
                                        <td colspan="8" class="px-4 py-12 text-center text-sm text-[#8ea095]">
                                            Belum ada data paket masuk.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Card mobile -->
                    <div class="mt-5 grid gap-4 xl:hidden">
                        <div
                            v-for="p in filteredPaket"
                            :key="`mobile-${p.paketin_id}`"
                            class="rounded-2xl border border-[#e5ebe6] bg-white p-4 shadow-sm"
                        >
                            <div>
                                <p class="text-sm font-semibold text-[#556b60]">
                                    Unit {{ p.nomor_unit || '-' }}
                                </p>
                                <p class="mt-1 text-xs text-[#8a9a91]">
                                    {{ p.tower_name || '-' }} • {{ p.expedisi_name || '-' }}
                                </p>
                            </div>

                            <div class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                                <div>
                                    <p class="text-[11px] uppercase tracking-wide text-[#8a9a91]">Tanggal</p>
                                    <p class="mt-1 text-[#556b60]">{{ formatDate(p.input_date) }}</p>
                                </div>

                                <div>
                                    <p class="text-[11px] uppercase tracking-wide text-[#8a9a91]">Jam</p>
                                    <p class="mt-1 text-[#556b60]">{{ p.input_time || '-' }}</p>
                                </div>

                                <div>
                                    <p class="text-[11px] uppercase tracking-wide text-[#8a9a91]">Resepsionis</p>
                                    <p class="mt-1 text-[#556b60]">{{ p.penerima_input || '-' }}</p>
                                </div>

                                <div>
                                    <p class="text-[11px] uppercase tracking-wide text-[#8a9a91]">Nama Penghuni</p>
                                    <p class="mt-1 text-[#556b60]">{{ p.kepada || '-' }}</p>
                                </div>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <Link
                                    :href="route('paket.show', p.paketin_id)"
                                    class="inline-flex flex-1 items-center justify-center rounded-lg bg-blue-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-blue-600"
                                >
                                    View
                                </Link>

                                <Link
                                    :href="route('paket.edit', p.paketin_id)"
                                    class="inline-flex flex-1 items-center justify-center rounded-lg bg-amber-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-amber-600"
                                >
                                    Edit Detail
                                </Link>
                            </div>
                        </div>

                        <div
                            v-if="!filteredPaket.length"
                            class="rounded-2xl border border-[#e5ebe6] bg-white px-4 py-10 text-center text-sm text-[#8ea095] shadow-sm"
                        >
                            Belum ada data paket masuk.
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>

<style scoped>
.table-scroll {
    scrollbar-width: thin;
    scrollbar-color: #a3a3a3 #e5e7eb;
}

.table-scroll::-webkit-scrollbar {
    height: 12px;
}

.table-scroll::-webkit-scrollbar-track {
    background: #e5e7eb;
    border-radius: 9999px;
}

.table-scroll::-webkit-scrollbar-thumb {
    background: #a3a3a3;
    border-radius: 9999px;
}

.table-scroll::-webkit-scrollbar-thumb:hover {
    background: #8b8b8b;
}
</style>