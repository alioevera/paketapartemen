<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref, onMounted, onBeforeUnmount } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    paket: {
        type: Object,
        required: true,
    },
    authUser: {
        type: Object,
        default: () => ({}),
    },
})

const bulanIndonesia = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
]

const formatTanggalIndonesia = (value) => {
    if (!value) return '-'

    if (/^\d{4}-\d{2}-\d{2}$/.test(value)) {
        const [y, m, d] = value.split('-')
        return `${Number(d)} ${bulanIndonesia[Number(m) - 1]} ${y}`
    }

    return value
}

const getCurrentDate = () => {
    const now = new Date()
    const y = now.getFullYear()
    const m = String(now.getMonth() + 1).padStart(2, '0')
    const d = String(now.getDate()).padStart(2, '0')
    return `${y}-${m}-${d}`
}

const getCurrentTime = () => {
    const now = new Date()
    const h = String(now.getHours()).padStart(2, '0')
    const i = String(now.getMinutes()).padStart(2, '0')
    return `${h}:${i}`
}

const form = useForm({
    out_date: props.paket?.paketout?.out_date || getCurrentDate(),
    out_time: props.paket?.paketout?.out_time || getCurrentTime(),
    pengambil: props.paket?.paketout?.pengambil || '',
})

let timer = null

onMounted(() => {
    if (!props.paket?.paketout) {
        timer = setInterval(() => {
            form.out_date = getCurrentDate()
            form.out_time = getCurrentTime()
        }, 1000)
    }
})

onBeforeUnmount(() => {
    if (timer) clearInterval(timer)
})

const submit = () => {
    form.put(route('paket.update', props.paket.paketin_id))
}
</script>

<template>
    <Head title="Edit Detail Paket" />

    <AppLayout
        active-menu="lihat-paket"
        :user-name="authUser?.user_name || 'User'"
    >
        <div class="space-y-6">
            <!-- HEADER -->
            <section class="rounded-3xl bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-[#556b60]">
                            Edit Detail Paket
                        </h2>
                        <p class="mt-1 text-sm text-[#8a9a91]">
                            Perbarui informasi paket keluar dengan tampilan yang lebih rapi dan terstruktur.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <Link
                            :href="route('lihat-paket.index')"
                            class="inline-flex items-center justify-center rounded-2xl bg-[#edf3ef] px-4 py-2.5 text-sm font-medium text-[#556b60] transition hover:bg-[#e2ebe4]"
                        >
                            Kembali
                        </Link>
                    </div>
                </div>
            </section>

            <!-- FOTO + RINGKASAN -->
            <section class="rounded-3xl bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-5 flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-[#556b60]">Foto & Ringkasan Paket</h3>
                        <p class="mt-1 text-sm text-[#8a9a91]">
                            Tampilan foto paket dan informasi utama paket masuk.
                        </p>
                    </div>

                    <span
                        class="inline-flex rounded-full px-3 py-1.5 text-xs font-semibold"
                        :class="paket.status_verifikasi === 'Pending'
                            ? 'bg-amber-100 text-amber-700'
                            : 'bg-emerald-100 text-emerald-700'"
                    >
                        {{ paket.status_verifikasi || 'Pending' }}
                    </span>
                </div>

                <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
                    <!-- FOTO -->
                    <div class="rounded-2xl p-4">
                        <div class="flex h-[220px] items-center justify-center rounded-2xl bg-[#eef3ef] sm:h-[280px] p-3">
                            <img
                                v-if="paket.foto_paket"
                                :src="`/storage/${paket.foto_paket}`"
                                alt="Foto Paket"
                                class="max-h-full max-w-full rounded-xl object-contain"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center rounded-xl border border-dashed border-[#d4ddd7] text-center text-sm text-[#8ea095]"
                            >
                                Tidak ada foto paket
                            </div>
                        </div>
                    </div>

                    <!-- RINGKASAN -->
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl bg-[#f8fbf9] p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Unit</p>
                            <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                {{ paket.unit || '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#f8fbf9] p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Tower</p>
                            <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                {{ paket.tower_name || '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#f8fbf9] p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Nama Penghuni</p>
                            <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                {{ paket.penghuni_name || '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#f8fbf9] p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Ekspedisi</p>
                            <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                {{ paket.expedisi_name || '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#f8fbf9] p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Tanggal Masuk</p>
                            <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                {{ formatTanggalIndonesia(paket.input_date) }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#f8fbf9] p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Jam Masuk</p>
                            <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                {{ paket.input_time || '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#f8fbf9] p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Bentuk Paket</p>
                            <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                {{ paket.bentuk_paket || '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#f8fbf9] p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Jumlah Paket</p>
                            <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                {{ paket.jumlah_paket || '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#f8fbf9] p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Lokasi Simpan</p>
                            <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                {{ paket.lokasi_simpan || '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#f8fbf9] p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Resepsionis Penerima</p>
                            <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                {{ paket.reception_name || '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- INFORMASI DETAIL -->
            <form @submit.prevent="submit" class="w-full">
                <!-- INFORMASI PAKET KELUAR -->
                <section class="rounded-3xl bg-white p-5 shadow-sm sm:p-6">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold text-[#556b60]">Informasi Paket Keluar</h3>
                        <p class="mt-1 text-sm text-[#8a9a91]">
                            Isi data pengambilan paket sesuai tabel paketout.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                Tanggal Keluar
                            </label>
                            <input
                                v-model="form.out_date"
                                type="date"
                                class="w-full rounded-2xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none transition focus:border-[#92a99a] focus:ring-2 focus:ring-[#edf3ef]"
                            />
                            <p v-if="form.errors.out_date" class="mt-1 text-sm text-rose-500">
                                {{ form.errors.out_date }}
                            </p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                Jam Keluar
                            </label>
                            <input
                                v-model="form.out_time"
                                type="time"
                                class="w-full rounded-2xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none transition focus:border-[#92a99a] focus:ring-2 focus:ring-[#edf3ef]"
                            />
                            <p v-if="form.errors.out_time" class="mt-1 text-sm text-rose-500">
                                {{ form.errors.out_time }}
                            </p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                Nama Pengambil
                            </label>
                            <input
                                v-model="form.pengambil"
                                type="text"
                                placeholder="Masukkan nama pengambil"
                                class="w-full rounded-2xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none transition focus:border-[#92a99a] focus:ring-2 focus:ring-[#edf3ef]"
                            />
                            <p v-if="form.errors.pengambil" class="mt-1 text-sm text-rose-500">
                                {{ form.errors.pengambil }}
                            </p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                Saksi / Resepsionis
                            </label>
                            <input
                                :value="authUser?.user_name || '-'"
                                type="text"
                                readonly
                                class="w-full rounded-2xl border border-[#d8e0da] bg-[#f4f6f8] px-4 py-3 text-sm text-[#556b60] outline-none"
                            />
                            <p class="mt-1 text-xs text-[#8a9a91]">
                                Otomatis mengikuti user yang sedang login.
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-5 py-3 text-sm font-semibold text-white shadow-[0_10px_20px_rgba(111,143,127,0.22)] transition hover:-translate-y-0.5 disabled:opacity-70"
                        >
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                        </button>

                        <Link
                            :href="route('paket.show', paket.paketin_id)"
                            class="inline-flex items-center justify-center rounded-2xl bg-[#edf3ef] px-5 py-3 text-sm font-medium text-[#556b60] transition hover:bg-[#e2ebe4]"
                        >
                            Batal
                        </Link>
                    </div>
                </section>
            </form>
        </div>
    </AppLayout>
</template>