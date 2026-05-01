<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { computed } from 'vue'

const props = defineProps({
    authUser: {
        type: Object,
        default: () => ({}),
    },
    expedisi: {
        type: Array,
        default: () => [],
    },
})

const page = usePage()

const form = useForm({
    foto: null,
})

const ocrResult = computed(() => page.props.flash?.ocr_result || null)

const selectedImagePreview = computed(() => {
    if (!form.foto) return null
    return URL.createObjectURL(form.foto)
})

const onFileChange = (event) => {
    form.foto = event.target.files[0] || null
}

const submitOCR = () => {
    form.post(route('paket-masuk.ocr.process'), {
        forceFormData: true,
    })
}

const buildManualRoute = () => {
    if (!ocrResult.value) return route('paket-masuk.create')

    const params = {}

    if (ocrResult.value.detected_unit) {
        params.unit = ocrResult.value.detected_unit
    }

    const query = new URLSearchParams(params).toString()

    return query
        ? `${route('paket-masuk.create')}?${query}`
        : route('paket-masuk.create')
}
</script>

<template>
    <Head title="Input Paket dengan OCR" />

    <AppLayout
        title="Input Paket dengan OCR"
        active-menu="lihat-paket"
        :user-name="authUser?.user_name || 'User'"
    >
        <div class="space-y-6">
            <section class="rounded-3xl bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-[#556b60]">
                            Tambah Paket dengan OCR
                        </h2>
                        <p class="mt-1 text-sm text-[#8a9a91]">
                            Upload foto label/resi paket, lalu sistem akan membaca teks otomatis.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <Link
                            :href="route('lihat-paket.index')"
                            class="inline-flex items-center justify-center rounded-2xl bg-[#edf3ef] px-4 py-2.5 text-sm font-medium text-[#556b60] transition hover:bg-[#e2ebe4]"
                        >
                            Kembali
                        </Link>

                        <Link
                            :href="route('paket-masuk.create')"
                            class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-4 py-2.5 text-sm font-semibold text-white shadow-[0_10px_20px_rgba(111,143,127,0.20)] transition hover:-translate-y-0.5"
                        >
                            Input Manual
                        </Link>
                    </div>
                </div>
            </section>

            <section class="grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
                <div class="rounded-3xl bg-white p-5 shadow-sm sm:p-6">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold text-[#556b60]">
                            Upload Gambar
                        </h3>
                        <p class="mt-1 text-sm text-[#8a9a91]">
                            Gunakan gambar label paket atau resi yang jelas.
                        </p>
                    </div>

                    <form @submit.prevent="submitOCR" class="space-y-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                                Foto Paket / Resi
                            </label>
                            <input
                                type="file"
                                accept="image/*"
                                @change="onFileChange"
                                class="w-full rounded-2xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none file:mr-3 file:rounded-xl file:border-0 file:bg-[#edf3ef] file:px-4 file:py-2 file:text-sm file:font-medium file:text-[#556b60]"
                            />
                            <p v-if="form.errors.foto" class="mt-1 text-sm text-rose-500">
                                {{ form.errors.foto }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-[#e4ebe5] bg-[#f8fbf9] p-4">
                            <div class="flex h-[280px] items-center justify-center rounded-2xl bg-[#eef3ef] p-3">
                                <img
                                    v-if="selectedImagePreview"
                                    :src="selectedImagePreview"
                                    alt="Preview OCR"
                                    class="max-h-full max-w-full rounded-xl object-contain"
                                />
                                <div
                                    v-else
                                    class="flex h-full w-full items-center justify-center rounded-2xl border border-dashed border-[#d6dfd8] text-center text-sm text-[#8ea095]"
                                >
                                    Preview gambar akan muncul di sini
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <button
                                type="submit"
                                :disabled="form.processing || !form.foto"
                                class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-5 py-3 text-sm font-semibold text-white shadow-[0_10px_20px_rgba(111,143,127,0.22)] transition hover:-translate-y-0.5 disabled:opacity-70"
                            >
                                {{ form.processing ? 'Memproses OCR...' : 'Proses OCR' }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm sm:p-6">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold text-[#556b60]">
                            Hasil OCR
                        </h3>
                        <p class="mt-1 text-sm text-[#8a9a91]">
                            Hasil ini masih bisa kamu koreksi sebelum menyimpan data paket.
                        </p>
                    </div>

                    <div v-if="ocrResult" class="space-y-4">
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-2xl bg-[#f8fbf9] p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Deteksi Unit</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ ocrResult.detected_unit || '-' }}
                                </p>
                            </div>

                            <div class="rounded-2xl bg-[#f8fbf9] p-4">
                                <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">Deteksi Expedisi dari OCR</p>
                                <p class="mt-1 text-sm font-semibold text-[#556b60]">
                                    {{ ocrResult.detected_expedisi_name || '-' }}
                                </p>
                            </div>
                        </div>

                        <div
                            v-if="ocrResult.matched_expedisi_options && ocrResult.matched_expedisi_options.length"
                            class="rounded-2xl border border-[#e4ebe5] bg-[#fbfcfb] p-4"
                        >
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">
                                Cocok dengan Master Expedisi
                            </p>

                            <div class="mt-3 flex flex-wrap gap-2">
                                <span
                                    v-for="item in ocrResult.matched_expedisi_options"
                                    :key="item.expedisi_id"
                                    class="inline-flex rounded-full bg-[#edf3ef] px-3 py-1 text-xs font-medium text-[#556b60]"
                                >
                                    {{ item.expedisi_name }}
                                </span>
                            </div>

                            <p class="mt-3 text-xs text-[#8a9a91]">
                                Expedisi tidak dipilih otomatis. Silakan pilih manual pada form tambah paket.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-[#e4ebe5] bg-[#fbfcfb] p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-[#8a9a91]">
                                Teks OCR Mentah
                            </p>
                            <pre class="mt-3 whitespace-pre-wrap text-sm leading-6 text-[#556b60]">{{ ocrResult.raw_text || '-' }}</pre>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <Link
                                :href="buildManualRoute()"
                                class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-5 py-3 text-sm font-semibold text-white shadow-[0_10px_20px_rgba(111,143,127,0.22)] transition hover:-translate-y-0.5"
                            >
                                Gunakan Hasil OCR
                            </Link>

                            <Link
                                :href="route('paket-masuk.create')"
                                class="inline-flex items-center justify-center rounded-2xl bg-[#edf3ef] px-5 py-3 text-sm font-medium text-[#556b60] transition hover:bg-[#e2ebe4]"
                            >
                                Lanjut Manual Kosong
                            </Link>
                        </div>
                    </div>

                    <div
                        v-else
                        class="flex min-h-[280px] items-center justify-center rounded-2xl border border-dashed border-[#d8e0da] bg-[#fbfcfb] text-center text-sm text-[#8ea095]"
                    >
                        Hasil OCR akan muncul di sini setelah gambar diproses.
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>