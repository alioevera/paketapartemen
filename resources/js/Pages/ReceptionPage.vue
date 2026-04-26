<script setup>
import { Head, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    receptions: {
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

const isAdmin = computed(() => props.authUser?.role === 'admin')

const addForm = useForm({
    user_nik: '',
    user_name: '',
    username: '',
    password: '',
    role: 'receptionist',
    tower_id: '',
})

const editForm = useForm({
    old_user_nik: '',
    user_nik: '',
    user_name: '',
    username: '',
    password: '',
    role: 'receptionist',
    tower_id: '',
})

watch(() => addForm.role, (value) => {
    if (value === 'admin') {
        addForm.tower_id = ''
    }
})

watch(() => editForm.role, (value) => {
    if (value === 'admin') {
        editForm.tower_id = ''
    }
})

const openAddModal = () => {
    addForm.reset()
    addForm.role = 'receptionist'
    addForm.tower_id = ''
    addForm.clearErrors()
    showAddModal.value = true
}

const closeAddModal = () => {
    showAddModal.value = false
}

const submitAdd = () => {
    addForm.post(route('reception.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeAddModal()
        },
    })
}

const openEditModal = (item) => {
    editForm.old_user_nik = item.user_nik
    editForm.user_nik = item.user_nik
    editForm.user_name = item.user_name
    editForm.username = item.username
    editForm.password = ''
    editForm.role = item.role
    editForm.tower_id = item.tower_id || ''
    editForm.clearErrors()
    showEditModal.value = true
}

const closeEditModal = () => {
    showEditModal.value = false
}

const submitEdit = () => {
    editForm.put(route('reception.update', editForm.old_user_nik), {
        preserveScroll: true,
        onSuccess: () => {
            closeEditModal()
        },
    })
}

const deleteReception = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus reception ini?')) {
        router.delete(route('reception.destroy', id), {
            preserveScroll: true,
        })
    }
}
</script>

<template>
    <Head title="Data Reception" />

    <AppLayout
        title="Data Resepsionis"
        active-menu="reception"
        :user-name="authUser?.user_name || 'User'"
    >
        <section class="rounded-2xl bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-[#ebefec] px-4 py-4 sm:px-6">
                <div>
                    <h2 class="text-lg font-semibold text-[#5f7067]">Daftar Reception</h2>
                    <p class="text-sm text-[#8a9a91]">Kelola data resepsionis apartemen</p>
                </div>

                <button
                    v-if="isAdmin"
                    type="button"
                    @click="openAddModal"
                    class="rounded-xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-4 py-2.5 text-sm font-semibold text-white shadow-[0_10px_20px_rgba(111,143,127,0.22)] transition hover:-translate-y-0.5"
                >
                    + Tambah Reception
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
                                <th class="border border-[#e5ebe6] px-4 py-3">NIK</th>
                                <th class="border border-[#e5ebe6] px-4 py-3">Nama</th>
                                <th class="border border-[#e5ebe6] px-4 py-3">Username</th>
                                <th class="border border-[#e5ebe6] px-4 py-3">Tower</th>
                                <th class="border border-[#e5ebe6] px-4 py-3">Role</th>
                                <th class="border border-[#e5ebe6] px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in receptions"
                                :key="item.user_nik"
                                class="text-[#5f7067] hover:bg-[#fbfcfb]"
                            >
                                <td class="border border-[#e5ebe6] px-4 py-3">{{ index + 1 }}</td>
                                <td class="border border-[#e5ebe6] px-4 py-3">{{ item.user_nik }}</td>
                                <td class="border border-[#e5ebe6] px-4 py-3">{{ item.user_name }}</td>
                                <td class="border border-[#e5ebe6] px-4 py-3">{{ item.username }}</td>
                                <td class="border border-[#e5ebe6] px-4 py-3">
                                    {{ item.role === 'admin' ? '-' : (item.tower_name || '-') }}
                                </td>
                                <td class="border border-[#e5ebe6] px-4 py-3">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                                        :class="item.role === 'admin'
                                            ? 'bg-emerald-100 text-emerald-700'
                                            : 'bg-slate-100 text-slate-700'"
                                    >
                                        {{ item.role }}
                                    </span>
                                </td>
                                <td class="border border-[#e5ebe6] px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button
                                            v-if="isAdmin"
                                            type="button"
                                            @click="openEditModal(item)"
                                            class="rounded-lg bg-amber-400 px-3 py-2 text-xs font-semibold text-white transition hover:bg-amber-500"
                                        >
                                            Ubah Data
                                        </button>

                                        <button
                                            v-else
                                            type="button"
                                            disabled
                                            class="cursor-not-allowed rounded-lg bg-slate-300 px-3 py-2 text-xs font-semibold text-white"
                                        >
                                            Ubah Data
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="!receptions.length">
                                <td colspan="7" class="border border-[#e5ebe6] px-4 py-8 text-center text-[#8ea095]">
                                    Belum ada data reception.
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
                    <h3 class="text-lg font-semibold text-[#5f7067]">Tambah Reception</h3>
                </div>

                <form @submit.prevent="submitAdd" class="space-y-4 px-5 py-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">NIK Reception</label>
                        <input v-model="addForm.user_nik" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="addForm.errors.user_nik" class="mt-1 text-sm text-rose-500">{{ addForm.errors.user_nik }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Nama Reception</label>
                        <input v-model="addForm.user_name" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="addForm.errors.user_name" class="mt-1 text-sm text-rose-500">{{ addForm.errors.user_name }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Username</label>
                        <input v-model="addForm.username" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="addForm.errors.username" class="mt-1 text-sm text-rose-500">{{ addForm.errors.username }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Password</label>
                        <input v-model="addForm.password" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="addForm.errors.password" class="mt-1 text-sm text-rose-500">{{ addForm.errors.password }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Role</label>
                        <select v-model="addForm.role" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none">
                            <option value="receptionist">Receptionist</option>
                            <option value="admin">Admin</option>
                        </select>
                        <p v-if="addForm.errors.role" class="mt-1 text-sm text-rose-500">{{ addForm.errors.role }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Tower</label>
                        <select
                            v-model="addForm.tower_id"
                            :disabled="addForm.role === 'admin'"
                            class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none disabled:bg-[#f4f6f8]"
                        >
                            <option value="">Pilih Tower</option>
                            <option
                                v-for="tower in towers"
                                :key="tower.tower_id"
                                :value="tower.tower_id"
                            >
                                {{ tower.tower_name }}
                            </option>
                        </select>
                        <p class="mt-1 text-xs text-[#8a9a91]">
                            Untuk admin, tower dikosongkan karena dapat mengakses semua tower.
                        </p>
                        <p v-if="addForm.errors.tower_id" class="mt-1 text-sm text-rose-500">{{ addForm.errors.tower_id }}</p>
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
                    <h3 class="text-lg font-semibold text-[#5f7067]">Edit Reception</h3>
                </div>

                <form @submit.prevent="submitEdit" class="space-y-4 px-5 py-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">NIK Reception</label>
                        <input v-model="editForm.user_nik" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="editForm.errors.user_nik" class="mt-1 text-sm text-rose-500">{{ editForm.errors.user_nik }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Nama Reception</label>
                        <input v-model="editForm.user_name" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="editForm.errors.user_name" class="mt-1 text-sm text-rose-500">{{ editForm.errors.user_name }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Username</label>
                        <input v-model="editForm.username" type="text" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="editForm.errors.username" class="mt-1 text-sm text-rose-500">{{ editForm.errors.username }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Password Baru</label>
                        <input v-model="editForm.password" type="text" placeholder="Kosongkan jika tidak ingin ganti password" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none" />
                        <p v-if="editForm.errors.password" class="mt-1 text-sm text-rose-500">{{ editForm.errors.password }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Role</label>
                        <select v-model="editForm.role" class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none">
                            <option value="receptionist">Receptionist</option>
                            <option value="admin">Admin</option>
                        </select>
                        <p v-if="editForm.errors.role" class="mt-1 text-sm text-rose-500">{{ editForm.errors.role }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-[#6e7f75]">Tower</label>
                        <select
                            v-model="editForm.tower_id"
                            :disabled="editForm.role === 'admin'"
                            class="w-full rounded-xl border border-[#d8e0da] bg-white px-4 py-3 text-sm text-[#556b60] outline-none disabled:bg-[#f4f6f8]"
                        >
                            <option value="">Pilih Tower</option>
                            <option
                                v-for="tower in towers"
                                :key="tower.tower_id"
                                :value="tower.tower_id"
                            >
                                {{ tower.tower_name }}
                            </option>
                        </select>
                        <p class="mt-1 text-xs text-[#8a9a91]">
                            Untuk admin, tower dikosongkan karena dapat mengakses semua tower.
                        </p>
                        <p v-if="editForm.errors.tower_id" class="mt-1 text-sm text-rose-500">{{ editForm.errors.tower_id }}</p>
                    </div>

                    <div class="mt-6 flex justify-between gap-3">
                        <button
                            type="button"
                            @click="deleteReception(editForm.old_user_nik)"
                            class="rounded-xl bg-rose-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-600"
                        >
                            Delete
                        </button>

                        <div class="flex gap-3">
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
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>