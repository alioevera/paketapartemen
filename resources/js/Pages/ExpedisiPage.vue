<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    expedisi: {
        type: Array,
        default: () => [],
    },
    authUser: {
        type: Object,
        default: () => ({}),
    },
})

const showAddModal = ref(false)
const showEditModal = ref(false)
const selectedExpedisi = ref(null)

const addForm = useForm({
    expedisi_name: '',
})

const editForm = useForm({
    expedisi_id: null,
    expedisi_name: '',
})

const openAddModal = () => {
    addForm.reset()
    addForm.clearErrors()
    showAddModal.value = true
}

const closeAddModal = () => {
    showAddModal.value = false
}

const submitAdd = () => {
    addForm.post(route('expedisi.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeAddModal()
        },
    })
}

const openEditModal = (item) => {
    selectedExpedisi.value = item
    editForm.expedisi_id = item.expedisi_id
    editForm.expedisi_name = item.expedisi_name
    editForm.clearErrors()
    showEditModal.value = true
}

const closeEditModal = () => {
    showEditModal.value = false
}

const submitEdit = () => {
    editForm.put(route('expedisi.update', editForm.expedisi_id), {
        preserveScroll: true,
        onSuccess: () => {
            closeEditModal()
        },
    })
}

const deleteExpedisi = (id) => {
    if (confirm('Yakin hapus?')) {
        router.delete(route('expedisi.destroy', id), {
            preserveScroll: true,
        })
    }
}
</script>

<template>
    <Head title="Data Expedisi" />

    <AppLayout
        title="Data Expedisi"
        active-menu="expedisi"
        :user-name="authUser?.user_name || 'User'"
    >
        <section class="rounded-2xl bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-[#ebefec] px-4 py-4 sm:px-6">
                <div>
                    <h2 class="text-lg font-semibold text-[#5f7067]">Daftar Expedisi</h2>
                    <p class="text-sm text-[#8a9a91]">Kelola data expedisi apartemen</p>
                </div>

                <button
                    type="button"
                    @click="openAddModal"
                    class="rounded-xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-4 py-2.5 text-sm font-semibold text-white shadow-[0_10px_20px_rgba(111,143,127,0.22)] transition hover:-translate-y-0.5"
                >
                    + Tambah Expedisi
                </button>
            </div>

            <div class="px-4 py-5 sm:px-6">
                <div
                    v-if="$page.props.flash?.success"
                    class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
                >
                    {{ $page.props.flash.success }}
                </div>

                <div class="overflow-x-auto rounded-xl border border-[#e5ebe6]">
                    <table class="min-w-full border-collapse text-sm">
                        <thead>
                            <tr class="bg-[#f5f7f6] text-left text-[#6b7d72]">
                                <th class="border border-[#e5ebe6] px-4 py-3">No</th>
                                <th class="border border-[#e5ebe6] px-4 py-3">Nama Expedisi</th>
                                <th class="border border-[#e5ebe6] px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in expedisi"
                                :key="item.expedisi_id"
                                class="text-[#5f7067] hover:bg-[#fbfcfb]"
                            >
                                <td class="border border-[#e5ebe6] px-4 py-3">
                                    {{ index + 1 }}
                                </td>
                                <td class="border border-[#e5ebe6] px-4 py-3">
                                    {{ item.expedisi_name }}
                                </td>
                                <td class="border border-[#e5ebe6] px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button
                                            type="button"
                                            @click="openEditModal(item)"
                                            class="rounded-lg bg-amber-400 px-3 py-2 text-xs font-semibold text-white transition hover:bg-amber-500"
                                        >
                                            Edit
                                        </button>

                                        <button
                                            type="button"
                                            @click="deleteExpedisi(item.expedisi_id)"
                                            class="rounded-lg bg-rose-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-rose-600"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="!expedisi.length">
                                <td colspan="3" class="border border-[#e5ebe6] px-4 py-8 text-center text-[#8ea095]">
                                    Belum ada data expedisi.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Modal Add -->
        <div
            v-if="showAddModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/35 px-4"
        >
            <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">
                <div class="border-b border-[#ebefec] px-5 py-4">
                    <h3 class="text-lg font-semibold text-[#5f7067]">Tambah Expedisi</h3>
                </div>

                <form @submit.prevent="submitAdd" class="px-5 py-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                            Nama Expedisi
                        </label>
                        <input
                            v-model="addForm.expedisi_name"
                            type="text"
                            class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none focus:border-[#8aa293]"
                            placeholder="Masukkan nama expedisi"
                        />
                        <p v-if="addForm.errors.expedisi_name" class="mt-1 text-sm text-rose-500">
                            {{ addForm.errors.expedisi_name }}
                        </p>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button
                            type="button"
                            @click="closeAddModal"
                            class="rounded-xl bg-[#edf3ef] px-5 py-3 text-sm font-medium text-[#556b60] transition hover:bg-[#e2ebe4]"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            :disabled="addForm.processing"
                            class="rounded-xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 disabled:opacity-70"
                        >
                            {{ addForm.processing ? 'Menyimpan...' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit -->
        <div
            v-if="showEditModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/35 px-4"
        >
            <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">
                <div class="border-b border-[#ebefec] px-5 py-4">
                    <h3 class="text-lg font-semibold text-[#5f7067]">Edit Expedisi</h3>
                </div>

                <form @submit.prevent="submitEdit" class="px-5 py-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                            ID Expedisi
                        </label>
                        <input
                            :value="editForm.expedisi_id"
                            type="text"
                            disabled
                            class="w-full rounded-xl border border-[#d8e0da] bg-[#f4f6f8] px-4 py-3 text-sm text-[#556b60] outline-none"
                        />
                    </div>

                    <div class="mt-4">
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">
                            Nama Expedisi
                        </label>
                        <input
                            v-model="editForm.expedisi_name"
                            type="text"
                            class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none focus:border-[#8aa293]"
                            placeholder="Masukkan nama expedisi"
                        />
                        <p v-if="editForm.errors.expedisi_name" class="mt-1 text-sm text-rose-500">
                            {{ editForm.errors.expedisi_name }}
                        </p>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button
                            type="button"
                            @click="closeEditModal"
                            class="rounded-xl bg-[#edf3ef] px-5 py-3 text-sm font-medium text-[#556b60] transition hover:bg-[#e2ebe4]"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            :disabled="editForm.processing"
                            class="rounded-xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 disabled:opacity-70"
                        >
                            {{ editForm.processing ? 'Mengupdate...' : 'Update' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>