<script setup>
import { Head, useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    penghuni: {
        type: Array,
        default: () => [],
    },
    towers: {
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

const addForm = useForm({
    tower_id: '',
    unit: '',
    nama_penghuni: '',
    nomor_telepon: '',
    email: '',
})

const editForm = useForm({
    penghuni_id: null,
    tower_id: '',
    unit: '',
    nama_penghuni: '',
    nomor_telepon: '',
    email: '',
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
    addForm.post(route('penghuni.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeAddModal()
        },
    })
}

const openEditModal = (item) => {
    editForm.penghuni_id = item.penghuni_id
    editForm.tower_id = item.tower_id
    editForm.unit = item.unit
    editForm.nama_penghuni = item.nama_penghuni
    editForm.nomor_telepon = item.nomor_telepon
    editForm.email = item.email
    editForm.clearErrors()
    showEditModal.value = true
}

const closeEditModal = () => {
    showEditModal.value = false
}

const submitEdit = () => {
    editForm.put(route('penghuni.update', editForm.penghuni_id), {
        preserveScroll: true,
        onSuccess: () => {
            closeEditModal()
        },
    })
}

const deletePenghuni = (id) => {
    if (confirm('Yakin hapus?')) {
        router.delete(route('penghuni.destroy', id), {
            preserveScroll: true,
        })
    }
}
</script>

<template>
    <Head title="Data Penghuni" />

    <AppLayout
        title="Data Penghuni"
        active-menu="penghuni"
        :user-name="authUser?.user_name || 'User'"
    >
        <section class="rounded-2xl bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-[#ebefec] px-4 py-4 sm:px-6">
                <div>
                    <h2 class="text-lg font-semibold text-[#5f7067]">Daftar Penghuni</h2>
                    <p class="text-sm text-[#8a9a91]">Kelola data penghuni apartemen</p>
                </div>

                <button
                    type="button"
                    @click="openAddModal"
                    class="rounded-xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-4 py-2.5 text-sm font-semibold text-white shadow-[0_10px_20px_rgba(111,143,127,0.22)] transition hover:-translate-y-0.5"
                >
                    + Tambah Penghuni
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
                                <th class="border border-[#e5ebe6] px-4 py-3">Tower</th>
                                <th class="border border-[#e5ebe6] px-4 py-3">Unit</th>
                                <th class="border border-[#e5ebe6] px-4 py-3">Nama Penghuni</th>
                                <th class="border border-[#e5ebe6] px-4 py-3">Nomor Telepon</th>
                                <th class="border border-[#e5ebe6] px-4 py-3">Email</th>
                                <th class="border border-[#e5ebe6] px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in penghuni"
                                :key="item.penghuni_id"
                                class="text-[#5f7067] hover:bg-[#fbfcfb]"
                            >
                                <td class="border border-[#e5ebe6] px-4 py-3">{{ index + 1 }}</td>
                                <td class="border border-[#e5ebe6] px-4 py-3">{{ item.tower_name }}</td>
                                <td class="border border-[#e5ebe6] px-4 py-3">{{ item.unit }}</td>
                                <td class="border border-[#e5ebe6] px-4 py-3">{{ item.nama_penghuni }}</td>
                                <td class="border border-[#e5ebe6] px-4 py-3">{{ item.nomor_telepon }}</td>
                                <td class="border border-[#e5ebe6] px-4 py-3">{{ item.email }}</td>
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
                                            @click="deletePenghuni(item.penghuni_id)"
                                            class="rounded-lg bg-rose-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-rose-600"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="!penghuni.length">
                                <td colspan="7" class="border border-[#e5ebe6] px-4 py-8 text-center text-[#8ea095]">
                                    Belum ada data penghuni.
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
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl">
                <div class="border-b border-[#ebefec] px-5 py-4">
                    <h3 class="text-lg font-semibold text-[#5f7067]">Tambah Penghuni</h3>
                </div>

                <form @submit.prevent="submitAdd" class="px-5 py-5 space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Tower</label>
                        <select
                            v-model="addForm.tower_id"
                            class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none"
                        >
                            <option value="">Pilih Tower</option>
                            <option v-for="tower in towers" :key="tower.tower_id" :value="tower.tower_id">
                                {{ tower.tower_name }}
                            </option>
                        </select>
                        <p v-if="addForm.errors.tower_id" class="mt-1 text-sm text-rose-500">{{ addForm.errors.tower_id }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Unit</label>
                        <input v-model="addForm.unit" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="addForm.errors.unit" class="mt-1 text-sm text-rose-500">{{ addForm.errors.unit }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Nama Penghuni</label>
                        <input v-model="addForm.nama_penghuni" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="addForm.errors.nama_penghuni" class="mt-1 text-sm text-rose-500">{{ addForm.errors.nama_penghuni }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Nomor Telepon</label>
                        <input v-model="addForm.nomor_telepon" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="addForm.errors.nomor_telepon" class="mt-1 text-sm text-rose-500">{{ addForm.errors.nomor_telepon }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Email</label>
                        <input v-model="addForm.email" type="email" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="addForm.errors.email" class="mt-1 text-sm text-rose-500">{{ addForm.errors.email }}</p>
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
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl">
                <div class="border-b border-[#ebefec] px-5 py-4">
                    <h3 class="text-lg font-semibold text-[#5f7067]">Edit Penghuni</h3>
                </div>

                <form @submit.prevent="submitEdit" class="px-5 py-5 space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">ID Penghuni</label>
                        <input
                            :value="editForm.penghuni_id"
                            type="text"
                            disabled
                            class="w-full rounded-xl border border-[#d8e0da] bg-[#f4f6f8] px-4 py-3 text-sm text-[#556b60] outline-none"
                        />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Tower</label>
                        <select
                            v-model="editForm.tower_id"
                            class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none"
                        >
                            <option value="">Pilih Tower</option>
                            <option v-for="tower in towers" :key="tower.tower_id" :value="tower.tower_id">
                                {{ tower.tower_name }}
                            </option>
                        </select>
                        <p v-if="editForm.errors.tower_id" class="mt-1 text-sm text-rose-500">{{ editForm.errors.tower_id }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Unit</label>
                        <input v-model="editForm.unit" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="editForm.errors.unit" class="mt-1 text-sm text-rose-500">{{ editForm.errors.unit }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Nama Penghuni</label>
                        <input v-model="editForm.nama_penghuni" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="editForm.errors.nama_penghuni" class="mt-1 text-sm text-rose-500">{{ editForm.errors.nama_penghuni }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Nomor Telepon</label>
                        <input v-model="editForm.nomor_telepon" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="editForm.errors.nomor_telepon" class="mt-1 text-sm text-rose-500">{{ editForm.errors.nomor_telepon }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Email</label>
                        <input v-model="editForm.email" type="email" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="editForm.errors.email" class="mt-1 text-sm text-rose-500">{{ editForm.errors.email }}</p>
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