<script setup>
import { computed, ref, watch } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

const show = ref(true);
const style = computed(
    () => usePage().props.value.jetstream.flash?.bannerStyle || "success"
);
const message = computed(
    () => usePage().props.value.jetstream.flash?.banner || ""
);

watch(message, async () => {
    show.value = true;
});
</script>

<template>
    <div
        class="fixed inset-0 z-50 flex items-start justify-center px-4 py-6 pointer-events-none sm:p-6 sm:justify-end"
    >
        <transition
            appear
            enter-active-class="transition duration-300 ease-out transform"
            enter-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition duration-100 ease-in"
            leave-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-show="message && show"
                class="w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-lg pointer-events-auto ring-1 ring-black ring-opacity-5"
                @mouseleave="show = false"
            >
                <div class="p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span
                                class="flex p-2 rounded-lg"
                                :class="{
                                    'bg-indigo-600': style == 'success',
                                    'bg-red-600': style == 'danger',
                                }"
                            >
                                <svg
                                    v-if="style == 'success'"
                                    class="w-5 h-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>

                                <svg
                                    v-if="style == 'danger'"
                                    class="w-5 h-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                    />
                                </svg>
                            </span>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="mt-1 text-sm font-semibold text-gray-500">
                                {{ message }}
                            </p>
                        </div>
                        <div class="flex flex-shrink-0 ml-4">
                            <button
                                type="button"
                                :class="{
                                    'hover:bg-indigo-600 focus:bg-indigo-600 focus:ring-indigo-500':
                                        style == 'success',
                                    'hover:bg-red-600 focus:bg-red-600 focus:ring-red-500':
                                        style == 'danger',
                                }"
                                class="inline-flex p-2 text-gray-400 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2"
                                aria-label="Dismiss"
                                @click.prevent="show = false"
                            >
                                <span class="sr-only">Close</span>
                                <svg
                                    class="w-5 h-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
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
            </div>
        </transition>
    </div>
</template>
