<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3'
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

const form = useForm({
    out_date: props.paket?.paketout?.out_date && props.paket?.paketout?.out_time
        ? `${props.paket.paketout.out_date}T${props.paket.paketout.out_time}`
        : '',
    pengambil: props.paket?.paketout?.pengambil || '',
    send_pengingat: props.paket?.paketout?.send_pengingat ?? false,
})

const submit = () => {
    form.put(route('paket.update', props.paket.paketin_id))
}
</script>

<template>
    <Head title="Edit Detail Paket" />

    <AppLayout
        title="Edit Detail Paket"
        active-menu="lihat-paket"
        :user-name="authUser?.user_name || 'User'"
    >
        <section class="rounded-2xl bg-white shadow-sm">
            <div class="border-b border-[#ebefec] px-5 py-4 sm:px-6">
                <h2 class="text-lg font-semibold text-[#5f7067]">Edit Detail Paket</h2>
                <p class="text-sm text-[#8a9a91]">
                    Edit data paket keluar berdasarkan migration paketout.
                </p>
            </div>

            <div class="space-y-6 px-5 py-5 sm:px-6">
                <div class="rounded-2xl border border-[#e5ebe6] bg-[#fafcfb] p-5">
                    <h3 class="mb-4 text-base font-semibold text-[#556b60]">Informasi Paket</h3>

                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">ID Paket</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.paketin_id }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Unit</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.unit || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Tower</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.tower?.tower_name || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Nama Penghuni</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.penghuni?.nama_penghuni || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Expedisi</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.expedisi?.expedisi_name || '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Resepsionis Input</p>
                            <p class="mt-1 text-sm text-[#556b60]">{{ paket.reception?.user_name || '-' }}</p>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="submit" class="rounded-2xl border border-[#e5ebe6] bg-white p-5 shadow-sm">
                    <h3 class="mb-4 text-base font-semibold text-[#556b60]">Data Paket Keluar</h3>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                Tanggal & Jam Keluar
                            </label>
                            <input
                                v-model="form.out_date"
                                type="datetime-local"
                                class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none transition focus:border-[#8aa293] focus:ring-2 focus:ring-[#edf3ef]"
                            />
                            <p v-if="form.errors.out_date" class="mt-1 text-sm text-rose-500">
                                {{ form.errors.out_date }}
                            </p>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                Pengambil
                            </label>
                            <input
                                v-model="form.pengambil"
                                type="text"
                                placeholder="Masukkan nama pengambil"
                                class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none transition focus:border-[#8aa293] focus:ring-2 focus:ring-[#edf3ef]"
                            />
                            <p v-if="form.errors.pengambil" class="mt-1 text-sm text-rose-500">
                                {{ form.errors.pengambil }}
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                Saksi / Resepsionis Keluar
                            </label>
                            <input
                                :value="authUser?.user_name || '-'"
                                type="text"
                                disabled
                                class="w-full rounded-xl border border-[#d8e0da] bg-[#f4f6f8] px-4 py-3 text-sm text-[#556b60] outline-none"
                            />
                            <p class="mt-1 text-xs text-[#8a9a91]">
                                Otomatis menggunakan user yang sedang login.
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-3 block text-sm font-medium text-[#6e7f75]">
                                Send Pengingat
                            </label>

                            <div class="flex flex-wrap items-center gap-3">
                                <button
                                    type="button"
                                    @click="form.send_pengingat = true"
                                    class="inline-flex items-center justify-center rounded-xl bg-blue-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-600"
                                    :disabled="form.send_pengingat"
                                >
                                    {{ form.send_pengingat ? 'Pengingat Sudah Ditandai' : 'Kirim Pengingat' }}
                                </button>

                                <button
                                    v-if="form.send_pengingat"
                                    type="button"
                                    @click="form.send_pengingat = false"
                                    class="inline-flex items-center justify-center rounded-xl bg-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-300"
                                >
                                    Batal Tandai
                                </button>
                            </div>

                            <p class="mt-2 text-xs text-[#8a9a91]">
                                Tombol ini menandai bahwa pengingat sudah dikirim.
                            </p>

                            <p v-if="form.errors.send_pengingat" class="mt-1 text-sm text-rose-500">
                                {{ form.errors.send_pengingat }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <Link
                            :href="route('paket.show', paket.paketin_id)"
                            class="inline-flex items-center justify-center rounded-xl bg-[#edf3ef] px-5 py-3 text-sm font-medium text-[#556b60] transition hover:bg-[#e2ebe4]"
                        >
                            Kembali
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 disabled:opacity-70"
                        >
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </AppLayout>
</template>