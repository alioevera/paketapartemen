<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import logo from '../../assets/u-residence-logo.png'

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
})

const form = useForm({
    username: '',
    password: '',
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <Head title="Login" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600|allura:400|parisienne:400&display=swap" rel="stylesheet" />

    <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[#e8efe9] px-3 py-4 sm:px-4 sm:py-6">
        <div class="absolute -left-24 -top-24 h-[360px] w-[360px] rounded-full bg-[#9fb7a7]/20 blur-3xl sm:h-[560px] sm:w-[560px]"></div>
        <div class="absolute -right-10 bottom-0 h-[260px] w-[260px] rounded-full bg-[#d7c3a3]/20 blur-3xl sm:h-[420px] sm:w-[420px]"></div>

        <div class="relative z-10 w-full max-w-6xl overflow-hidden rounded-[24px] border border-white/40 bg-white/60 shadow-[0_20px_60px_rgba(50,70,60,0.12)] backdrop-blur-xl sm:rounded-[32px]">
            <div class="grid min-h-[auto] grid-cols-1 md:min-h-[620px] md:grid-cols-[440px_1fr] lg:grid-cols-[500px_1fr]">
                <div class="relative overflow-hidden bg-gradient-to-br from-[#7f9d8b] via-[#6f8f7f] to-[#5e7b6c] px-6 py-8 sm:px-8 sm:py-10 md:px-10 md:py-14">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.18),transparent_35%)]"></div>
                    <div class="absolute -right-24 top-0 hidden h-full w-[260px] rounded-l-[999px] bg-white/10 md:block"></div>

                    <div class="relative flex h-full flex-col items-center justify-center">
                        <div class="mb-4 text-center sm:mb-6">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.35em] text-white/70 sm:text-xs">
                                Welcome
                            </p>
                        </div>

                        <div class="flex items-center justify-center">
                            <img
                                :src="logo"
                                alt="U Residence Logo"
                                class="h-32 w-auto object-contain drop-shadow-[0_14px_28px_rgba(0,0,0,0.16)] sm:h-44 md:h-56"
                            />
                        </div>

                        <div class="mt-5 max-w-[280px] text-center sm:mt-7">
                            <h2 class="text-lg font-semibold tracking-[0.14em] text-[#f6efe5] sm:text-xl md:text-2xl">
                                U RESIDENCE
                            </h2>
                            <p
                                class="mt-1 text-[22px] leading-none text-[#2f241d] sm:text-[24px] md:text-[26px]"
                                style="font-family: 'Allura', cursive; word-spacing: 0.18em;"
                            >
                                It's all about u
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center px-4 py-6 sm:px-8 sm:py-8 md:px-12 lg:px-16">
                    <div class="w-full max-w-sm sm:max-w-md">
                        <div class="mb-6 sm:mb-8">
                            <h1 class="text-3xl font-bold tracking-[0.06em] text-[#50685b] sm:text-4xl">
                                Login
                            </h1>
                            <p class="mt-2 text-sm leading-6 text-[#7c8f83]">
                                Please enter your account details to continue.
                            </p>
                        </div>

                        <div
                            v-if="status"
                            class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
                        >
                            {{ status }}
                        </div>

                        <form @submit.prevent="submit" class="space-y-4 sm:space-y-5">
                            <div>
                                <label for="username" class="mb-2 block text-sm font-medium text-[#6f8377]">
                                    Username
                                </label>

                                <div class="flex items-center rounded-xl border border-[#d7dfd9] bg-white/80 px-3.5 shadow-sm transition focus-within:border-[#9bb3a3] focus-within:ring-3 focus-within:ring-[#cfdad3]/50 sm:px-4">
                                    <input
                                        id="username"
                                        v-model="form.username"
                                        type="text"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        autocapitalize="off"
                                        spellcheck="false"
                                        placeholder="Masukkan username"
                                        class="w-full border-0 bg-transparent py-2.5 text-sm text-[#4f6157] placeholder:text-[#a8b6ae] focus:outline-none focus:ring-0 sm:py-3"
                                    />

                                    <svg class="h-4 w-4 shrink-0 text-[#9caf9f] sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="8" r="4"></circle>
                                        <path d="M4 20c1.5-4 5-6 8-6s6.5 2 8 6"></path>
                                    </svg>
                                </div>

                                <p v-if="form.errors.username" class="mt-1 text-sm text-rose-500">
                                    {{ form.errors.username }}
                                </p>
                            </div>

                            <div>
                                <label for="password" class="mb-2 block text-sm font-medium text-[#6f8377]">
                                    Password
                                </label>

                                <div class="flex items-center rounded-xl border border-[#d7dfd9] bg-white/80 px-3.5 shadow-sm transition focus-within:border-[#9bb3a3] focus-within:ring-3 focus-within:ring-[#cfdad3]/50 sm:px-4">
                                    <input
                                        id="password"
                                        v-model="form.password"
                                        type="password"
                                        required
                                        autocomplete="current-password"
                                        placeholder="Masukkan password"
                                        class="w-full border-0 bg-transparent py-2.5 text-sm text-[#4f6157] placeholder:text-[#a8b6ae] focus:outline-none focus:ring-0 sm:py-3"
                                    />

                                    <svg class="h-4 w-4 shrink-0 text-[#9caf9f] sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                                        <path d="M8 11V8a4 4 0 1 1 8 0v3"></path>
                                    </svg>
                                </div>

                                <p v-if="form.errors.password" class="mt-1 text-sm text-rose-500">
                                    {{ form.errors.password }}
                                </p>
                            </div>

                            <div class="pt-1 text-right">
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="text-sm font-medium text-[#9d8a6a] transition hover:text-[#857253] hover:underline"
                                >
                                    Forgot password?
                                </Link>
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="mt-2 w-full rounded-xl bg-gradient-to-r from-[#829f8e] to-[#6e8b7b] px-5 py-3 text-sm font-semibold tracking-[0.1em] text-white shadow-[0_10px_20px_rgba(111,143,127,0.22)] transition hover:-translate-y-0.5 hover:shadow-[0_14px_24px_rgba(111,143,127,0.24)] disabled:opacity-70"
                            >
                                {{ form.processing ? 'LOADING...' : 'LOGIN' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>