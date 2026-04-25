<script setup>
import { Head, Link } from '@inertiajs/vue3'
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

const formatDate = (value) => {
    if (!value) return '-'
    if (/^\d{4}-\d{2}-\d{2}$/.test(value)) {
        const [y, m, d] = value.split('-')
        return `${d}-${m}-${y}`
    }
    return value
}
</script>

<template>
    <Head title="Detail Paket" />

    <AppLayout
        title="Detail Paket"
        active-menu="lihat-paket"
        :user-name="authUser?.user_name || 'User'"
    >
        <section class="rounded-2xl bg-white shadow-sm">
            <div class="border-b border-[#ebefec] px-5 py-4 sm:px-6">
                <h2 class="text-lg font-semibold text-[#5f7067]">Detail Paket</h2>
                <p class="text-sm text-[#8a9a91]">
                    Informasi lengkap paket masuk dan paket keluar.
                </p>
            </div>

            <div class="space-y-6 px-5 py-5 sm:px-6">
                <div class="rounded-2xl border border-[#e5ebe6] bg-[#fafcfb] p-5">
                    <h3 class="mb-4 text-base font-semibold text-[#556b60]">Informasi Paket Masuk</h3>

                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Unit</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.unit || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Tower</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.tower_name || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Nama Penghuni</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.penghuni_name || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Ekspedisi</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.expedisi_name || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Tanggal Masuk</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ formatDate(paket.input_date) }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Jam Masuk</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.input_time || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Resepsionis</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.reception_name || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Bentuk Paket</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.bentuk_paket || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Jumlah Paket</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.jumlah_paket || '-' }}</p>
                        </div>

                        <div class="md:col-span-2 xl:col-span-3">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Lokasi Simpan</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.lokasi_simpan || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Status Verifikasi</p>
                            <span
                                class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                                :class="paket.status_verifikasi === 'Pending'
                                    ? 'bg-amber-100 text-amber-700'
                                    : 'bg-emerald-100 text-emerald-700'"
                            >
                                {{ paket.status_verifikasi || 'Pending' }}
                            </span>
                        </div>

                        <div class="md:col-span-2 xl:col-span-2">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Foto Paket</p>
                            <div class="mt-2">
                                <img
                                    v-if="paket.foto_paket"
                                    :src="`/storage/${paket.foto_paket}`"
                                    alt="Foto Paket"
                                    class="h-32 w-32 rounded-2xl object-cover ring-1 ring-[#e5ebe6]"
                                />
                                <div
                                    v-else
                                    class="flex h-32 w-32 items-center justify-center rounded-2xl border border-dashed border-[#d8e0da] bg-white text-center text-xs text-[#8ea095]"
                                >
                                    Tidak ada foto
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-[#e5ebe6] bg-[#fafcfb] p-5">
                    <h3 class="mb-4 text-base font-semibold text-[#556b60]">Informasi Paket Keluar</h3>

                    <div v-if="paket.paketout" class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Tanggal Keluar</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ formatDate(paket.paketout.out_date) }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Jam Keluar</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.paketout.out_time || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Pengambil</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.paketout.pengambil || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Saksi / Resepsionis</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.paketout.saksi_keluar || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Send Pengingat</p>
                            <span
                                class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                                :class="paket.paketout.send_pengingat
                                    ? 'bg-blue-100 text-blue-700'
                                    : 'bg-slate-100 text-slate-700'"
                            >
                                {{ paket.paketout.send_pengingat ? 'Sudah Dikirim' : 'Belum Dikirim' }}
                            </span>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Waktu Pengingat</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.paketout.pengingat_dikirim_at || '-' }}</p>
                        </div>
                    </div>

                    <div v-else class="rounded-xl border border-dashed border-[#d8e0da] bg-white px-4 py-6 text-sm text-[#8ea095]">
                        Paket ini belum memiliki data paket keluar.
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <Link
                        :href="route('lihat-paket.index')"
                        class="inline-flex items-center justify-center rounded-xl bg-[#edf3ef] px-5 py-3 text-sm font-medium text-[#556b60] transition hover:bg-[#e2ebe4]"
                    >
                        Kembali
                    </Link>

                    <Link
                        :href="route('paket.edit', paket.paketin_id)"
                        class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5"
                    >
                        Edit
                    </Link>
                </div>
            </div>
        </section>
    </AppLayout>
</template>