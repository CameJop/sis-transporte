<script setup>
import { ref } from 'vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-[#0f111a] font-nunito text-slate-300 transition-colors duration-300">
            <nav class="border-b border-white/5 bg-[#1a1d2b]/80 backdrop-blur-md sticky top-0 z-50">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between items-center">
                        <div class="flex">
                            <div class="flex shrink-0 items-center gap-3">
                                <Link :href="route('dashboard')" class="flex items-center gap-2 group hover:opacity-80 transition-opacity">
                                    <img src="/images/logo.png" alt="Logo" class="h-10 w-auto" />
                                </Link>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Panel Principal
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-[#e74c3c] to-[#c0392b] flex items-center justify-center text-white font-bold text-base shadow-[0_0_15px_rgba(192,57,43,0.4)] border border-white/10 relative select-none hover:scale-105 transition-transform duration-200">
                                {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-[#1a1d2b] animate-pulse"></span>
                            </div>
                        </div>

                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center rounded-md p-2 text-slate-400 transition duration-150 ease-in-out hover:bg-white/5 hover:text-white focus:bg-white/5 focus:text-white focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden bg-[#1a1d2b] border-t border-white/5"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Panel Principal
                        </ResponsiveNavLink>
                    </div>

                    <div class="border-t border-white/10 pb-4 pt-4 bg-[#141622]/50">
                        <div class="px-6 flex items-center gap-4">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-[#e74c3c] to-[#c0392b] flex items-center justify-center text-white font-bold text-base shadow-md">
                                {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                            </div>
                            <div>
                                <div class="text-base font-semibold text-white tracking-wide">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="text-xs font-medium text-slate-400">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <header
                class="bg-[#1a1d2b] border-b border-white/5 shadow-md"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <div class="text-white font-playfair">
                        <slot name="header" />
                    </div>
                </div>
            </header>

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Nunito:wght@400;500;600;700&display=swap');

.font-playfair {
    font-family: 'Playfair Display', serif;
}

.font-nunito {
    font-family: 'Nunito', sans-serif;
}
</style>