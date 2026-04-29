<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    authUser: Object,
    expedisi: Array,
})

const today = new Date()

const bulanIndonesia = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
]

const formatDate = (date) => {
    const y = date.getFullYear()
    const m = String(date.getMonth() + 1).padStart(2, '0')
    const d = String(date.getDate()).padStart(2, '0')
    return `${y}-${m}-${d}`
}

const formatTime = (date) => {
    const h = String(date.getHours()).padStart(2, '0')
    const i = String(date.getMinutes()).padStart(2, '0')
    return `${h}:${i}`
}

const formatTanggalIndonesia = (date) => {
    const d = date.getDate()
    const m = date.getMonth()
    const y = date.getFullYear()
    return `${d} ${bulanIndonesia[m]} ${y}`
}

const form = useForm({
    tanggal_masuk: formatDate(today),
    jam_masuk: formatTime(today),
    expedisi_id: '',
    unit: '',
    bentuk_paket: '',
    jumlah_paket: 1,
    lokasi_simpan: '',
    foto_paket: null,
})

const batasPengambilanReadonly = computed(() => {
    if (!form.tanggal_masuk || !form.jam_masuk) return ''

    const masuk = new Date(`${form.tanggal_masuk}T${form.jam_masuk}`)
    if (Number.isNaN(masuk.getTime())) return ''

    const deadline = new Date(masuk)
    deadline.setMonth(deadline.getMonth() + 1)
    deadline.setDate(deadline.getDate() - 7)

    return formatTanggalIndonesia(deadline)
})

const onFileChange = (event) => {
    form.foto_paket = event.target.files[0] || null
}

const submit = () => {
    form.post(route('paket-masuk.store'), {
        forceFormData: true,
    })
}
</script>

<template>
    <Head title="Tambah Paket Masuk" />

    <AppLayout
        title="Tambah Paket Masuk"
        active-menu="tambah-paket"
        :user-name="authUser?.user_name || 'User'"
    >
        <section class="rounded-md bg-white shadow-sm">
            <div class="px-4 py-5 sm:px-6">
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Tanggal Masuk</label>
                        <input
                            v-model="form.tanggal_masuk"
                            type="date"
                            class="w-full rounded border border-[#d8e0da] bg-[#f4f6f8] px-3 py-3 text-sm text-[#556b60] outline-none"
                        />
                        <p v-if="form.errors.tanggal_masuk" class="mt-1 text-sm text-rose-500">
                            {{ form.errors.tanggal_masuk }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Jam Masuk</label>
                        <input
                            v-model="form.jam_masuk"
                            type="time"
                            class="w-full rounded border border-[#d8e0da] bg-[#f4f6f8] px-3 py-3 text-sm text-[#556b60] outline-none"
                        />
                        <p v-if="form.errors.jam_masuk" class="mt-1 text-sm text-rose-500">
                            {{ form.errors.jam_masuk }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Penerima (Resepsionis)</label>
                        <input
                            :value="authUser?.user_name || ''"
                            type="text"
                            disabled
                            class="w-full rounded border border-[#d8e0da] bg-[#f4f6f8] px-3 py-3 text-sm text-[#556b60] outline-none"
                        />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Batas Pengambilan</label>
                        <input
                            :value="batasPengambilanReadonly"
                            type="text"
                            readonly
                            class="w-full rounded border border-[#d8e0da] bg-[#f4f6f8] px-3 py-3 text-sm text-[#556b60] outline-none"
                        />
                        <p class="mt-1 text-xs text-[#8a9a91]">
                            Otomatis dihitung: 1 bulan dari tanggal masuk dikurangi 7 hari.
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Ekspedisi</label>
                        <select
                            v-model="form.expedisi_id"
                            class="w-full rounded border border-[#d8e0da] bg-white px-3 py-3 text-sm text-[#556b60] outline-none"
                        >
                            <option value="">Pilih Ekspedisi</option>
                            <option
                                v-for="item in expedisi"
                                :key="item.expedisi_id"
                                :value="item.expedisi_id"
                            >
                                {{ item.expedisi_name }}
                            </option>
                        </select>
                        <p v-if="form.errors.expedisi_id" class="mt-1 text-sm text-rose-500">
                            {{ form.errors.expedisi_id }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Nomor Unit</label>
                        <input
                            v-model="form.unit"
                            type="text"
                            class="w-full rounded border border-[#d8e0da] bg-white px-3 py-3 text-sm text-[#556b60] outline-none"
                        />
                        <p v-if="form.errors.unit" class="mt-1 text-sm text-rose-500">
                            {{ form.errors.unit }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Bentuk Paket</label>
                        <input
                            v-model="form.bentuk_paket"
                            type="text"
                            class="w-full rounded border border-[#d8e0da] bg-white px-3 py-3 text-sm text-[#556b60] outline-none"
                        />
                        <p v-if="form.errors.bentuk_paket" class="mt-1 text-sm text-rose-500">
                            {{ form.errors.bentuk_paket }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Jumlah Paket</label>
                        <input
                            v-model="form.jumlah_paket"
                            type="number"
                            min="1"
                            class="w-full rounded border border-[#d8e0da] bg-white px-3 py-3 text-sm text-[#556b60] outline-none"
                        />
                        <p v-if="form.errors.jumlah_paket" class="mt-1 text-sm text-rose-500">
                            {{ form.errors.jumlah_paket }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Lokasi Simpan</label>
                        <input
                            v-model="form.lokasi_simpan"
                            type="text"
                            class="w-full rounded border border-[#d8e0da] bg-white px-3 py-3 text-sm text-[#556b60] outline-none"
                        />
                        <p v-if="form.errors.lokasi_simpan" class="mt-1 text-sm text-rose-500">
                            {{ form.errors.lokasi_simpan }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Foto Paket</label>
                        <input
                            type="file"
                            accept="image/*"
                            @change="onFileChange"
                            class="w-full rounded border border-[#d8e0da] bg-white px-3 py-3 text-sm text-[#556b60] outline-none file:mr-3 file:rounded-md file:border-0 file:bg-[#829f8e] file:px-3 file:py-2 file:text-sm file:font-medium file:text-white"
                        />
                        <p v-if="form.errors.foto_paket" class="mt-1 text-sm text-rose-500">
                            {{ form.errors.foto_paket }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Nama Pengambil</label>
                        <input
                            value=""
                            disabled
                            class="w-full rounded border border-[#d8e0da] bg-[#f4f6f8] px-3 py-3 text-sm text-[#9aa9a1] outline-none"
                        />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Saksi</label>
                        <input
                            value=""
                            type="text"
                            disabled
                            class="w-full rounded border border-[#d8e0da] bg-[#f4f6f8] px-3 py-3 text-sm text-[#9aa9a1] outline-none"
                        />
                    </div>

                    <div class="flex justify-end gap-3 pt-3">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="rounded-md bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-6 py-3 text-sm font-semibold text-white shadow-[0_10px_20px_rgba(111,143,127,0.22)] transition hover:-translate-y-0.5 disabled:opacity-70"
                        >
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Paket' }}
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </AppLayout>
</template>