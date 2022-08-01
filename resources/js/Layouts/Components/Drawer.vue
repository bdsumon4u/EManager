<script setup>
import { TemplateIcon, XIcon } from "@heroicons/vue/outline";
import { useDrawer } from "../composables/useDrawer";

const props = defineProps({
    drawerOpen: Boolean,
    drawerToggle: Function,
});

const { activeTab, isTabOpen } = useDrawer();

const activeClass = (tab, def) => {
    return isTabOpen(tab, def) ? "border-blue-600" : "border-transparent";
};
</script>

<template>
    <aside
        :class="[drawerOpen ? 'right-0' : '-right-72']"
        class="fixed top-0 bottom-0 right-0 z-50 transition-all duration-300 w-72"
    >
        <header class="fixed z-30 bg-gray-200 shadow w-72 dark:bg-black">
            <div
                class="flex items-center justify-between px-2 border-b h-14 dark:border-gray-700 dark:text-gray-200"
            >
                <ul class="flex">
                    <li
                        :class="activeClass('tab-1', true)"
                        class="mb-0.5 border-b-2"
                    >
                        <button @click="activeTab = 'tab-1'" class="px-3 h-14">
                            <TemplateIcon class="w-5 h-5" />
                        </button>
                    </li>
                    <li :class="activeClass('tab-2')" class="mb-0.5 border-b-2">
                        <button @click="activeTab = 'tab-2'" class="px-3 h-14">
                            <TemplateIcon class="w-5 h-5" />
                        </button>
                    </li>
                    <li :class="activeClass('tab-3')" class="mb-0.5 border-b-2">
                        <button @click="activeTab = 'tab-3'" class="px-3 h-14">
                            <TemplateIcon class="w-5 h-5" />
                        </button>
                    </li>
                </ul>
                <button
                    @click.stop="drawerToggle"
                    type="button"
                    class="px-3 h-14"
                >
                    <XIcon class="w-5 h-5" />
                </button>
            </div>
        </header>
        <div
            class="fixed z-30 h-full bg-gray-100 shadow w-72 top-14 dark:bg-black dark:text-gray-200"
        >
            <div
                v-if="isTabOpen('tab-1', true)"
                class="h-full scrollbar scrollbar-none"
            >
                <div class="p-2">Tab One</div>
            </div>
            <div
                v-if="isTabOpen('tab-2')"
                class="h-full scrollbar scrollbar-none"
            >
                <div class="p-2">Tab Two</div>
            </div>
            <div
                v-if="isTabOpen('tab-3')"
                class="h-full scrollbar scrollbar-none"
            >
                <div class="p-2">Tab Three</div>
            </div>
        </div>
    </aside>
</template>
