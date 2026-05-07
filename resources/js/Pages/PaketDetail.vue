<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    paket: {
        type: Object,
        default: () => ({}),
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

const formatBatasPengambilan = (tanggal, jam) => {
    if (!tanggal || !jam) return '-'

    const masuk = new Date(`${tanggal}T${jam}`)
    if (Number.isNaN(masuk.getTime())) return '-'

    const deadline = new Date(masuk)
    deadline.setMonth(deadline.getMonth() + 1)
    deadline.setDate(deadline.getDate() - 7)

    const d = deadline.getDate()
    const m = deadline.getMonth()
    const y = deadline.getFullYear()

    return `${d} ${bulanIndonesia[m]} ${y}`
}

const fotoPaketUrl = (path) => {
    if (!path) return null
    return `/storage/${path}`
}
</script>

<template>
    <Head :title="`Detail Paket #${paket?.paketin_id || ''}`" />

    <AppLayout
        title="Detail Paket"
        active-menu="lihat-paket"
        :user-name="authUser?.user_name || 'User'"
    >
        <div class="space-y-6">
            <section class="rounded-3xl bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-[#556b60]">
                            Detail Paket
                        </h2>
                        <p class="mt-1 text-sm text-[#8a9a91]">
                            Informasi lengkap paket masuk dan status pengambilannya.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <Link
                            :href="route('lihat-paket.index')"
                            class="inline-flex items-center justify-center rounded-2xl bg-[#edf3ef] px-4 py-2.5 text-sm font-medium text-[#556b60] transition hover:bg-[#e2ebe4]"
                        >
                            Kembali ke Daftar
                        </Link>

                        <Link
                            :href="route('paket.edit', paket.paketin_id)"
                            class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-4 py-2.5 text-sm font-semibold text-white shadow-[0_10px_20px_rgba(111,143,127,0.20)] transition hover:-translate-y-0.5"
                        >
                            Edit Detail
                        </Link>
                    </div>
                </div>
            </section>

            <section class="grid gap-6 xl:grid-cols-[360px_1fr]">
                <div class="rounded-3xl bg-white p-5 shadow-sm sm:p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-[#556b60]">
                            Foto Paket
                        </h3>
                        <p class="mt-1 text-sm text-[#8a9a91]">
                            Tampilan foto paket yang diunggah saat input paket masuk.
                        </p>
                    </div>

                    <div class="overflow-hidden rounded-3xl border border-[#e4ebe5] bg-[#f8fbf9]">
                        <img
                            v-if="fotoPaketUrl(paket.foto_paket)"
                            :src="fotoPaketUrl(paket.foto_paket)"
                            alt="Foto Paket"
                            class="h-[320px] w-full object-cover"
                        />
                        <div
                            v-else
                            class="flex h-[320px] items-center justify-center px-6 text-center text-sm text-[#8ea095]"
                        >
                            Foto paket tidak tersedia.
                        </div>
                    </div>

                    <div class="mt-5 rounded-2xl border border-[#e4ebe5] bg-[#fbfcfb] p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">
                            Status Paket
                        </p>
                        <div class="mt-3">
                            <span
                                class="inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                                :class="paket.status_verifikasi === 'Sudah Diambil'
                                    ? 'bg-emerald-100 text-emerald-700'
                                    : 'bg-amber-100 text-amber-700'"
                            >
                                {{ paket.status_verifikasi || '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-3xl bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-5">
                            <h3 class="text-lg font-semibold text-[#556b60]">
                                Informasi Paket Masuk
                            </h3>
                            <p class="mt-1 text-sm text-[#8a9a91]">
                                Data utama paket yang diterima oleh resepsionis.
                            </p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-2xl bg-[#f8fbf9] p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Nomor Unit</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ paket.unit || '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#eef4ff] border border-[#dbe6ff] p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#7a8fb5]">Nomor Resi</p>
                                <p class="mt-1 text-sm font-semibold tracking-wide text-[#3f5c9a]">
                                    {{ paket.nomor_resi || '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#f8fbf9] p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Tujuan Pengiriman</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ paket.penghuni_name || '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#f8fbf9] p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Tower</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ paket.tower_name || '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#f8fbf9] p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Ekspedisi</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ paket.expedisi_name || '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#f8fbf9] p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Penerima Input</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ paket.reception_name || '-' }}
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

                            <div class="rounded-2xl bg-[#f8fbf9] p-4 sm:col-span-2">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Lokasi Simpan</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ paket.lokasi_simpan || '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#f8fbf9] p-4 sm:col-span-2">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Batas Pengambilan</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ formatBatasPengambilan(paket.input_date, paket.input_time) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-5">
                            <h3 class="text-lg font-semibold text-[#556b60]">
                                Informasi Paket Keluar
                            </h3>
                            <p class="mt-1 text-sm text-[#8a9a91]">
                                Status pengambilan paket oleh penghuni atau pihak terkait.
                            </p>
                        </div>

                        <div
                            v-if="paket.paketout"
                            class="grid gap-4 sm:grid-cols-2"
                        >
                            <div class="rounded-2xl bg-[#f8fbf9] p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Tanggal Keluar</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ formatTanggalIndonesia(paket.paketout.out_date) }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#f8fbf9] p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Jam Keluar</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ paket.paketout.out_time || '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#f8fbf9] p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Pengambil</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ paket.paketout.pengambil || '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#f8fbf9] p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Saksi</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ paket.paketout.saksi_keluar || '-' }}
                                </p>
                            </div>
                        </div>

                        <div
                            v-else
                            class="rounded-2xl border border-dashed border-[#d8e0da] bg-[#fbfcfb] px-4 py-10 text-center text-sm text-[#8ea095]"
                        >
                            Paket ini belum diambil.
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>