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

const showTambahMenu = reactive({
    open: false,
})

const formatDate = (value) => {
    if (!value) return '-'

    const bulanIndonesia = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ]

    if (/^\d{4}-\d{2}-\d{2}$/.test(value)) {
        const [y, m, d] = value.split('-')
        return `${Number(d)} ${bulanIndonesia[Number(m) - 1]} ${y}`
    }

    return value
}

const formatDeadlineDate = (value) => {
    if (!value) return '-'

    const masuk = new Date(value.replace(' ', 'T'))
    if (Number.isNaN(masuk.getTime())) return '-'

    const deadline = new Date(masuk)
    deadline.setMonth(deadline.getMonth() + 1)
    deadline.setDate(deadline.getDate() - 7)

    const bulanIndonesia = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ]

    const d = deadline.getDate()
    const m = deadline.getMonth()
    const y = deadline.getFullYear()

    return `${d} ${bulanIndonesia[m]} ${y}`
}

const isOverThreeWeeksPending = (item) => {
    if (item.status_verifikasi !== 'Belum Diambil' || !item.input_date_raw) return false

    const masuk = new Date(item.input_date_raw.replace(' ', 'T'))
    if (Number.isNaN(masuk.getTime())) return false

    const now = new Date()
    const diffMs = now.getTime() - masuk.getTime()
    const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24))

    return diffDays > 21
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

                    <div class="relative">
                        <button
                            type="button"
                            @click="showTambahMenu.open = !showTambahMenu.open"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-4 py-2.5 text-sm font-semibold text-white shadow-[0_10px_20px_rgba(111,143,127,0.22)] transition hover:-translate-y-0.5"
                        >
                            <span>+ Tambah Paket</span>
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div
                            v-if="showTambahMenu.open"
                            class="absolute right-0 z-20 mt-3 w-[260px] overflow-hidden rounded-2xl border border-[#e5ebe6] bg-white shadow-[0_16px_40px_rgba(0,0,0,0.10)]"
                        >
                            <div class="border-b border-[#eef2ef] px-4 py-3">
                                <p class="text-sm font-semibold text-[#556b60]">Pilih Metode Input</p>
                                <p class="mt-1 text-xs text-[#8a9a91]">Tentukan cara menambahkan data paket masuk.</p>
                            </div>

                            <div class="p-2">
                                <Link
                                    :href="route('paket-masuk.create')"
                                    class="flex w-full items-start gap-3 rounded-xl px-3 py-3 text-left transition hover:bg-[#f7faf8]"
                                >
                                    <div class="mt-0.5 rounded-xl bg-[#edf3ef] p-2 text-[#6e8b7b]">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5H7.5A2.25 2.25 0 0 0 5.25 6.75v10.5A2.25 2.25 0 0 0 7.5 19.5h9A2.25 2.25 0 0 0 18.75 17.25v-4.5M15 3.75h5.25M17.625 1.125v5.25M10.5 9.75h3m-3 3h4.5m-4.5 3h3" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-[#556b60]">Input Manual</p>
                                        <p class="mt-1 text-xs text-[#8a9a91]">Isi data paket lewat form biasa.</p>
                                    </div>
                                </Link>

                                <Link
                                    :href="route('paket-masuk.ocr')"
                                    class="flex w-full items-start gap-3 rounded-xl px-3 py-3 text-left transition hover:bg-[#f7faf8]"
                                >
                                    <div class="mt-0.5 rounded-xl bg-[#eef4ff] p-2 text-[#5a78b2]">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h3m10.5 0h3m-16.5 9h3m10.5 0h3M7.5 3.75v3m0 10.5v3m9-16.5v3m0 10.5v3M9 7.5h6A1.5 1.5 0 0 1 16.5 9v6a1.5 1.5 0 0 1-1.5 1.5H9A1.5 1.5 0 0 1 7.5 15V9A1.5 1.5 0 0 1 9 7.5Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-[#556b60]">Input dengan OCR</p>
                                        <p class="mt-1 text-xs text-[#8a9a91]">Upload gambar lalu baca teks otomatis.</p>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
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
                            <p class="text-m font-semibold uppercase tracking-wide text-[#8a9a91]">
                                Tabel Paket
                            </p>
                        </div>

                        <div class="table-scroll w-full overflow-x-auto overflow-y-hidden rounded-xl border border-[#e5ebe6] bg-white">
                            <table class="min-w-[1250px] w-full border-separate border-spacing-0 text-sm text-[#5f7067]">
                                <thead>
                                    <tr class="bg-[#f5f7f6] text-left text-[#6b7d72]">
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Tanggal Masuk</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Jam Masuk</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Resepsionis</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Ekspedisi</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Unit</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Tower</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Nama Penghuni</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Batas Pengambilan</th>
                                        <th class="whitespace-nowrap border-b border-r border-[#e5ebe6] px-4 py-3 font-semibold">Status Verifikasi</th>
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
                                        <td class="whitespace-nowrap border-b border-r border-[#eef2ef] px-4 py-4">
                                            {{ formatDeadlineDate(p.input_date_raw) }}
                                        </td>
                                        <td class="whitespace-nowrap border-b border-r border-[#eef2ef] px-4 py-4">
                                            <span
                                                class="inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                                                :class="isOverThreeWeeksPending(p)
                                                    ? 'bg-rose-100 text-rose-700'
                                                    : p.status_verifikasi === 'Belum Diambil'
                                                        ? 'bg-amber-100 text-amber-700'
                                                        : 'bg-emerald-100 text-emerald-700'"
                                            >
                                                {{
                                                    isOverThreeWeeksPending(p)
                                                        ? 'Pending > 3 Minggu'
                                                        : (p.status_verifikasi || 'Belum Diambil')
                                                }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap border-b border-[#eef2ef] px-4 py-4">
                                            <div class="flex items-center justify-center gap-2">
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
                                        <td colspan="10" class="px-4 py-12 text-center text-sm text-[#8ea095]">
                                            Belum ada data paket masuk.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

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

                                <div>
                                    <p class="text-[11px] uppercase tracking-wide text-[#8a9a91]">Batas Pengambilan</p>
                                    <p class="mt-1 text-[#556b60]">{{ formatDeadlineDate(p.input_date_raw) }}</p>
                                </div>

                                <div>
                                    <p class="text-[11px] uppercase tracking-wide text-[#8a9a91]">Status</p>
                                    <span
                                        class="mt-1 inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                                        :class="isOverThreeWeeksPending(p)
                                            ? 'bg-rose-100 text-rose-700'
                                            : p.status_verifikasi === 'Belum Diambil'
                                                ? 'bg-amber-100 text-amber-700'
                                                : 'bg-emerald-100 text-emerald-700'"
                                    >
                                        {{
                                            isOverThreeWeeksPending(p)
                                                ? 'Belum Diambil > 3 Minggu'
                                                : (p.status_verifikasi || 'Belum Diambil')
                                        }}
                                    </span>
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
                                    Edit
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