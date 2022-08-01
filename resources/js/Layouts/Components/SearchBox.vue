<script setup>
import { SearchIcon } from "@heroicons/vue/solid";
import { useMagicKeys } from "@vueuse/core";
import { nextTick, ref, watch } from "vue";
import { useEscOrOutside } from "../../composables/useEscOrOutside";

const props = defineProps({
    id: String,
    searchId: String,
    searchBoxOpen: Boolean,
    openSearchBox: Function,
    closeSearchBox: Function,
});

const modalContent = ref(null);
const searchInput = ref(null);

const { ctrl_k } = useMagicKeys({
    passive: false,
    onEventFired(e) {
        if (e.ctrlKey && e.key === "k" && e.type === "keydown") {
            e.preventDefault();
        }
    },
});

watch(ctrl_k, (open) => open && props.openSearchBox());
useEscOrOutside(modalContent, props.closeSearchBox);

watch(
    () => props.searchBoxOpen,
    (open) => {
        open && nextTick(() => searchInput.value.focus());
    }
);
</script>

<template>
    <!-- Modal backdrop -->
    <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-100 ease-out"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-show="searchBoxOpen"
            aria-hidden="true"
            class="fixed inset-0 z-50 transition-opacity bg-gray-900 bg-opacity-40"
        ></div>
    </transition>
    <!-- Modal dialog -->
    <transition
        enter-active-class="transition duration-200 ease-in-out"
        enter-from-class="translate-y-4 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in-out"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-4 opacity-0"
    >
        <div
            v-show="searchBoxOpen"
            :id="id"
            aria-modal="true"
            class="fixed inset-0 z-50 flex items-start justify-center px-4 mb-4 overflow-hidden transform top-20 sm:px-6"
            role="dialog"
        >
            <div
                ref="modalContent"
                class="w-full max-w-2xl max-h-full overflow-auto bg-white rounded shadow-lg"
            >
                <!-- Search form -->
                <form class="border-b border-gray-200">
                    <div class="relative">
                        <label :for="searchId" class="sr-only">Search</label>
                        <input
                            :id="searchId"
                            ref="searchInput"
                            class="w-full py-3 pl-10 pr-4 placeholder-gray-400 border-0 appearance-none focus:ring-transparent"
                            placeholder="Search Anything…"
                            type="search"
                        />
                        <button
                            aria-label="Search"
                            class="absolute inset-0 right-auto group"
                            type="submit"
                        >
                            <SearchIcon
                                class="w-5 h-5 ml-4 mr-2 text-gray-400 fill-current shrink-0 group-hover:text-gray-500"
                            />
                        </button>
                    </div>
                </form>
                <div class="px-2 py-4">
                    <!-- Recent searches -->
                    <div class="mb-3 last:mb-0">
                        <div
                            class="px-2 mb-2 text-xs font-semibold text-gray-400 uppercase"
                        >
                            Recent searches
                        </div>
                        <ul class="text-sm">
                            <li>
                                <Link
                                    class="flex items-center p-2 text-gray-800 rounded hover:text-white hover:bg-indigo-500 group"
                                    to="#0"
                                    @click="() => {}"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 16 16"
                                        width="20"
                                        height="20"
                                        class="w-4 h-4 mr-3 text-gray-400 fill-current group-hover:text-white group-hover:text-opacity-50 shrink-0"
                                    >
                                        <path
                                            d="M15.707 14.293v.001a1 1 0 01-1.414 1.414L11.185 12.6A6.935 6.935 0 017 14a7.016 7.016 0 01-5.173-2.308l-1.537 1.3L0 8l4.873 1.12-1.521 1.285a4.971 4.971 0 008.59-2.835l1.979.454a6.971 6.971 0 01-1.321 3.157l3.107 3.112zM14 6L9.127 4.88l1.521-1.28a4.971 4.971 0 00-8.59 2.83L.084 5.976a6.977 6.977 0 0112.089-3.668l1.537-1.3L14 6z"
                                        ></path>
                                    </svg>
                                    <span
                                        >Form Builder - 23 hours on-demand
                                        video</span
                                    >
                                </Link>
                            </li>
                            <li>
                                <Link
                                    class="flex items-center p-2 text-gray-800 rounded hover:text-white hover:bg-indigo-500 group"
                                    to="#0"
                                    @click="() => {}"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 16 16"
                                        width="20"
                                        height="20"
                                        class="w-4 h-4 mr-3 text-gray-400 fill-current group-hover:text-white group-hover:text-opacity-50 shrink-0"
                                    >
                                        <path
                                            d="M15.707 14.293v.001a1 1 0 01-1.414 1.414L11.185 12.6A6.935 6.935 0 017 14a7.016 7.016 0 01-5.173-2.308l-1.537 1.3L0 8l4.873 1.12-1.521 1.285a4.971 4.971 0 008.59-2.835l1.979.454a6.971 6.971 0 01-1.321 3.157l3.107 3.112zM14 6L9.127 4.88l1.521-1.28a4.971 4.971 0 00-8.59 2.83L.084 5.976a6.977 6.977 0 0112.089-3.668l1.537-1.3L14 6z"
                                        ></path>
                                    </svg>
                                    <span
                                        >Master Digital Marketing Strategy
                                        course</span
                                    >
                                </Link>
                            </li>
                            <li>
                                <Link
                                    class="flex items-center p-2 text-gray-800 rounded hover:text-white hover:bg-indigo-500 group"
                                    to="#0"
                                    @click="() => {}"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 16 16"
                                        width="20"
                                        height="20"
                                        class="w-4 h-4 mr-3 text-gray-400 fill-current group-hover:text-white group-hover:text-opacity-50 shrink-0"
                                    >
                                        <path
                                            d="M15.707 14.293v.001a1 1 0 01-1.414 1.414L11.185 12.6A6.935 6.935 0 017 14a7.016 7.016 0 01-5.173-2.308l-1.537 1.3L0 8l4.873 1.12-1.521 1.285a4.971 4.971 0 008.59-2.835l1.979.454a6.971 6.971 0 01-1.321 3.157l3.107 3.112zM14 6L9.127 4.88l1.521-1.28a4.971 4.971 0 00-8.59 2.83L.084 5.976a6.977 6.977 0 0112.089-3.668l1.537-1.3L14 6z"
                                        ></path>
                                    </svg>
                                    <span>Dedicated forms for products</span>
                                </Link>
                            </li>
                            <li>
                                <Link
                                    class="flex items-center p-2 text-gray-800 rounded hover:text-white hover:bg-indigo-500 group"
                                    to="#0"
                                    @click="() => {}"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 16 16"
                                        width="20"
                                        height="20"
                                        class="w-4 h-4 mr-3 text-gray-400 fill-current group-hover:text-white group-hover:text-opacity-50 shrink-0"
                                    >
                                        <path
                                            d="M15.707 14.293v.001a1 1 0 01-1.414 1.414L11.185 12.6A6.935 6.935 0 017 14a7.016 7.016 0 01-5.173-2.308l-1.537 1.3L0 8l4.873 1.12-1.521 1.285a4.971 4.971 0 008.59-2.835l1.979.454a6.971 6.971 0 01-1.321 3.157l3.107 3.112zM14 6L9.127 4.88l1.521-1.28a4.971 4.971 0 00-8.59 2.83L.084 5.976a6.977 6.977 0 0112.089-3.668l1.537-1.3L14 6z"
                                        ></path>
                                    </svg>
                                    <span>Product Update - Q4 2021</span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <!-- Recent pages -->
                    <div class="mb-3 last:mb-0">
                        <div
                            class="px-2 mb-2 text-xs font-semibold text-gray-400 uppercase"
                        >
                            Recent pages
                        </div>
                        <ul class="text-sm">
                            <li>
                                <Link
                                    class="flex items-center p-2 text-gray-800 rounded hover:text-white hover:bg-indigo-500 group"
                                    to="#0"
                                    @click="() => {}"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 16 16"
                                        width="20"
                                        height="20"
                                        class="w-4 h-4 mr-3 text-gray-400 fill-current group-hover:text-white group-hover:text-opacity-50 shrink-0"
                                    >
                                        <path
                                            d="M14 0H2c-.6 0-1 .4-1 1v14c0 .6.4 1 1 1h8l5-5V1c0-.6-.4-1-1-1zM3 2h10v8H9v4H3V2z"
                                        ></path>
                                    </svg>
                                    <span
                                        ><span
                                            class="font-medium text-gray-800 group-hover:text-white"
                                            >Messages</span
                                        >
                                        - Conversation / … / Mike Mills</span
                                    >
                                </Link>
                            </li>
                            <li>
                                <Link
                                    class="flex items-center p-2 text-gray-800 rounded hover:text-white hover:bg-indigo-500 group"
                                    to="#0"
                                    @click="() => {}"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 16 16"
                                        width="20"
                                        height="20"
                                        class="w-4 h-4 mr-3 text-gray-400 fill-current group-hover:text-white group-hover:text-opacity-50 shrink-0"
                                    >
                                        <path
                                            d="M14 0H2c-.6 0-1 .4-1 1v14c0 .6.4 1 1 1h8l5-5V1c0-.6-.4-1-1-1zM3 2h10v8H9v4H3V2z"
                                        ></path>
                                    </svg>
                                    <span
                                        ><span
                                            class="font-medium text-gray-800 group-hover:text-white"
                                            >Messages</span
                                        >
                                        - Conversation / … / Eva Patrick</span
                                    >
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
