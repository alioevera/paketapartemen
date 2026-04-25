<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import logo from '../../assets/u-residence-logo.png'

const props = defineProps({
    filters: Object,
    stats: Object,
    paket: Object,
    paketPerHari: Array,
    expedisiTerbanyak: Array,
    paketPerTower: Array,
    authUser: Object,
})

const applyFilter = (event) => {
    const form = event.target.form ?? event.target.closest('form')
    const formData = new FormData(form)

    router.get(route('dashboard'), {
        search: formData.get('search') || '',
        tanggal_masuk: formData.get('tanggal_masuk') || '',
        tanggal_diambil: formData.get('tanggal_diambil') || '',
    }, {
        preserveState: true,
        replace: true,
    })
}

const resetFilter = () => {
    router.get(route('dashboard'), {}, {
        preserveState: true,
        replace: true,
    })
}

const maxValue = (arr, key) => {
    if (!arr?.length) return 1
    return Math.max(...arr.map(item => Number(item[key]) || 0), 1)
}

const formatDateTime = (value) => {
    if (!value) return '-'
    return new Date(value).toLocaleString('id-ID')
}

const formatDate = (value) => {
    if (!value) return '-'
    return new Date(value).toLocaleDateString('id-ID')
}
</script>

<template>
    <Head title="Dashboard" />

    <div class="min-h-screen bg-[#eff4f0] text-[#556b60]">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside class="hidden w-[250px] flex-col bg-gradient-to-b from-[#7f9d8b] via-[#6f8f7f] to-[#5f7d6e] text-white lg:flex">
                <div class="flex items-center gap-3 border-b border-white/10 px-5 py-5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/15">
                        <img :src="logo" alt="Logo" class="h-7 w-7 object-contain" />
                    </div>
                    <div>
                        <p class="text-sm font-bold tracking-[0.14em]">U RESIDENCE</p>
                    </div>
                </div>

                <div class="px-4 py-5">
                    <p class="mb-3 text-[10px] font-semibold uppercase tracking-[0.25em] text-white/45">
                        Receptionist
                    </p>

                    <div class="space-y-2">
                        <Link
                            :href="route('dashboard')"
                            class="flex items-center rounded-xl bg-white/14 px-4 py-3 text-sm font-medium"
                        >
                            Dashboard
                        </Link>

                        <a href="#" class="flex items-center justify-between rounded-xl px-4 py-3 text-sm text-white/80 transition hover:bg-white/10">
                            <span>Administrator</span>
                            <span>›</span>
                        </a>

                        <a href="#" class="flex items-center justify-between rounded-xl px-4 py-3 text-sm text-white/80 transition hover:bg-white/10">
                            <span>Data Expedisi</span>
                            <span>›</span>
                        </a>

                        <a href="#" class="flex items-center justify-between rounded-xl px-4 py-3 text-sm text-white/80 transition hover:bg-white/10">
                            <span>Data Paket</span>
                            <span>›</span>
                        </a>
                    </div>
                </div>

                <div class="mt-auto px-5 pb-6">
                    <div class="flex justify-center">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/12 text-lg">
                            ‹
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main -->
            <main class="flex-1">
                <!-- Top bar -->
                <header class="border-b border-[#dde6df] bg-[#f8faf8]">
                    <div class="flex items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                        <div class="lg:hidden flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#7f9d8b]">
                                <img :src="logo" alt="Logo" class="h-6 w-6 object-contain" />
                            </div>
                            <span class="text-sm font-semibold tracking-[0.14em] text-[#556b60]">U RESIDENCE</span>
                        </div>

                        <div class="ml-auto flex items-center gap-3">
                            <div class="text-right">
                                <p class="text-sm font-medium text-[#556b60]">{{ authUser?.name }}</p>
                            </div>
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#d8c6a7] text-xs font-semibold text-[#556b60]">
                                {{ authUser?.name?.charAt(0) || 'U' }}
                            </div>
                        </div>
                    </div>
                </header>

                <div class="px-4 py-5 sm:px-6 lg:px-8">
                    <h1 class="mb-5 text-[30px] font-medium text-[#5f7067]">Dashboard</h1>

                    <!-- Cards -->
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <div class="rounded-md border-l-[4px] border-l-[#6488e8] bg-white px-4 py-5 shadow-sm">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.08em] text-[#6488e8]">
                                        Total Paket Masuk Hari Ini
                                    </p>
                                    <p class="mt-2 text-2xl font-semibold text-[#5a6f63]">
                                        {{ stats.totalMasukHariIni }}
                                    </p>
                                </div>
                                <div class="text-[#d7dce3] text-2xl">🧺</div>
                            </div>
                        </div>

                        <div class="rounded-md border-l-[4px] border-l-[#4ecb98] bg-white px-4 py-5 shadow-sm">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.08em] text-[#4ecb98]">
                                        Total Paket Diambil Hari Ini
                                    </p>
                                    <p class="mt-2 text-2xl font-semibold text-[#5a6f63]">
                                        {{ stats.totalDiambilHariIni }}
                                    </p>
                                </div>
                                <div class="text-[#d7dce3] text-2xl">✔</div>
                            </div>
                        </div>

                        <div class="rounded-md border-l-[4px] border-l-[#ff6e57] bg-white px-4 py-5 shadow-sm md:col-span-2 xl:col-span-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.08em] text-[#ff6e57]">
                                        Total Paket Belum Diambil
                                    </p>
                                    <p class="mt-2 text-2xl font-semibold text-[#5a6f63]">
                                        {{ stats.totalBelumDiambil }}
                                    </p>
                                </div>
                                <div class="text-[#d7dce3] text-2xl">📦</div>
                            </div>
                        </div>
                    </div>

                    <!-- Table box -->
                    <section class="mt-5 rounded-md bg-white shadow-sm">
                        <div class="border-b border-[#ebefec] px-4 py-3">
                            <h2 class="text-sm font-semibold text-[#6488e8]">
                                Data Paket Masuk & Statistik
                            </h2>
                        </div>

                        <div class="px-4 py-4">
                            <form class="grid gap-4 lg:grid-cols-3">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                        Cari data paket
                                    </label>
                                    <input
                                        name="search"
                                        :value="filters?.search || ''"
                                        @change="applyFilter"
                                        type="text"
                                        placeholder="Ketik untuk mencari..."
                                        class="w-full rounded border border-[#d8e0da] bg-white px-3 py-2 text-sm text-[#556b60] outline-none transition focus:border-[#9bb3a3]"
                                    />
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                        Tanggal paket masuk
                                    </label>
                                    <input
                                        name="tanggal_masuk"
                                        :value="filters?.tanggal_masuk || ''"
                                        @change="applyFilter"
                                        type="date"
                                        class="w-full rounded border border-[#d8e0da] bg-white px-3 py-2 text-sm text-[#556b60] outline-none transition focus:border-[#9bb3a3]"
                                    />
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                        Tanggal paket diambil
                                    </label>
                                    <input
                                        name="tanggal_diambil"
                                        :value="filters?.tanggal_diambil || ''"
                                        @change="applyFilter"
                                        type="date"
                                        class="w-full rounded border border-[#d8e0da] bg-white px-3 py-2 text-sm text-[#556b60] outline-none transition focus:border-[#9bb3a3]"
                                    />
                                </div>

                                <div class="lg:col-span-3">
                                    <button
                                        type="button"
                                        @click="resetFilter"
                                        class="rounded bg-[#edf3ef] px-4 py-2 text-sm font-medium text-[#556b60] transition hover:bg-[#e2ebe4]"
                                    >
                                        Reset Filter
                                    </button>
                                </div>
                            </form>

                            <div class="mt-5 overflow-x-auto">
                                <table class="min-w-[1250px] w-full border-collapse text-sm">
                                    <thead>
                                        <tr class="bg-[#f5f7f6] text-left text-[#6b7d72]">
                                            <th class="border border-[#e5ebe6] px-3 py-2">Tanggal Masuk</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Jam Masuk</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Resepsionis</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Ekspedisi</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Unit</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Tower</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Nama</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Bentuk Paket</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Jumlah</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Lokasi</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Tanggal Ambil</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Jam Ambil</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Pengambil</th>
                                            <th class="border border-[#e5ebe6] px-3 py-2">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr
                                            v-for="item in paket.data"
                                            :key="item.paketin_id"
                                            class="text-[#5f7067] hover:bg-[#fbfcfb]"
                                        >
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{ formatDate(item.input_date) }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{ new Date(item.input_date).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{ item.reception?.user_name || '-' }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{ item.expedisi?.expedisi_name || '-' }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{ item.unit }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{ item.tower?.tower_name || '-' }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{ item.penghuni?.nama_penghuni || '-' }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{ item.bentuk_paket }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{ item.jumlah_paket }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{ item.lokasi_simpan }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{ item.paketout?.out_date ? formatDate(item.paketout.out_date) : '-' }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{
                                                    item.paketout?.out_date
                                                        ? new Date(item.paketout.out_date).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                                                        : '-'
                                                }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                {{ item.paketout?.pengambil || '-' }}
                                            </td>
                                            <td class="border border-[#e5ebe6] px-3 py-2">
                                                <span
                                                    class="rounded px-2 py-1 text-xs font-medium"
                                                    :class="item.paketout
                                                        ? 'bg-[#e8f7ef] text-[#369d70]'
                                                        : 'bg-[#fff0ec] text-[#d86b57]'"
                                                >
                                                    {{ item.paketout ? 'Diambil' : 'Pending' }}
                                                </span>
                                            </td>
                                        </tr>

                                        <tr v-if="!paket.data.length">
                                            <td colspan="14" class="border border-[#e5ebe6] px-4 py-8 text-center text-[#8ea095]">
                                                Belum ada data paket.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <template v-for="link in paket.links" :key="link.label">
                                    <component
                                        :is="link.url ? Link : 'span'"
                                        :href="link.url || undefined"
                                        v-html="link.label"
                                        class="rounded px-3 py-2 text-sm transition"
                                        :class="[
                                            link.active
                                                ? 'bg-[#7f9d8b] text-white'
                                                : 'bg-[#eef3ef] text-[#556b60] hover:bg-[#e1e9e2]',
                                            !link.url ? 'cursor-not-allowed opacity-50' : ''
                                        ]"
                                    />
                                </template>
                            </div>
                        </div>
                    </section>

                    <!-- Bottom cards -->
                    <div class="mt-5 grid gap-4 xl:grid-cols-3">
                        <section class="rounded-md bg-white shadow-sm">
                            <div class="border-b border-[#ebefec] px-4 py-3">
                                <h3 class="text-sm font-semibold text-[#6488e8]">Paket / Hari</h3>
                            </div>
                            <div class="px-4 py-4">
                                <div class="flex h-[230px] items-end gap-4">
                                    <div
                                        v-for="item in paketPerHari"
                                        :key="item.tanggal"
                                        class="flex flex-1 flex-col items-center justify-end"
                                    >
                                        <div class="mb-2 text-xs text-[#7a8c81]">{{ item.total }}</div>
                                        <div
                                            class="w-full max-w-[48px] rounded-t bg-[#9fb4ef]"
                                            :style="{ height: `${(item.total / maxValue(paketPerHari, 'total')) * 160 + 20}px` }"
                                        ></div>
                                        <div class="mt-2 text-[11px] text-center text-[#7a8c81]">
                                            {{ formatDate(item.tanggal) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-md bg-white shadow-sm">
                            <div class="border-b border-[#ebefec] px-4 py-3">
                                <h3 class="text-sm font-semibold text-[#6488e8]">Ekspedisi Terbanyak</h3>
                            </div>
                            <div class="px-4 py-6">
                                <div class="mx-auto flex h-[220px] w-[220px] items-center justify-center rounded-full bg-[conic-gradient(#6488e8_0_35%,#4ecb98_35%_55%,#f0b83a_55%_72%,#ff6e57_72%_88%,#9fa8da_88%_100%)]">
                                    <div class="flex h-[110px] w-[110px] items-center justify-center rounded-full bg-white text-center text-xs text-[#6c7e74]">
                                        Total<br />Ekspedisi
                                    </div>
                                </div>

                                <div class="mt-5 grid grid-cols-2 gap-2 text-xs">
                                    <div
                                        v-for="item in expedisiTerbanyak"
                                        :key="item.expedisi_name"
                                        class="rounded bg-[#f6f8f7] px-3 py-2 text-[#6c7e74]"
                                    >
                                        {{ item.expedisi_name }} ({{ item.total }})
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-md bg-white shadow-sm">
                            <div class="border-b border-[#ebefec] px-4 py-3">
                                <h3 class="text-sm font-semibold text-[#6488e8]">Paket / Tower</h3>
                            </div>
                            <div class="px-4 py-4">
                                <div class="space-y-4">
                                    <div
                                        v-for="item in paketPerTower"
                                        :key="item.tower_name"
                                    >
                                        <div class="mb-1 flex items-center justify-between text-sm text-[#6e7f75]">
                                            <span>{{ item.tower_name }}</span>
                                            <span>{{ item.total }}</span>
                                        </div>
                                        <div class="h-5 rounded bg-[#eef3ef]">
                                            <div
                                                class="h-5 rounded bg-gradient-to-r from-[#71c89b] to-[#52b888]"
                                                :style="{ width: `${(item.total / maxValue(paketPerTower, 'total')) * 100}%` }"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>