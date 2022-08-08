<script setup>
import Inertia from "./Components/Inertia.vue";
import { useDrawer } from "./composables/useDrawer";
import { useScreen } from "./composables/useScreen";
import { useSearchBox } from "./composables/useSearchBox";
import { useSidebar } from "./composables/useSidebar";

const props = defineProps({
    title: String,
});

const { screenType } = useScreen();
const { sidebarFull, sidebarToggle } = useSidebar();
const { drawerOpen, drawerToggle } = useDrawer();
const { searchBoxOpen, openSearchBox, closeSearchBox } = useSearchBox();
</script>

<template>
    <div
        :class="{ 'sidebar-maximized': sidebarFull }"
        v-bind:screen="screenType"
    >
        <div
            class="flex flex-col flex-auto flex-shrink-0 min-h-screen antialiased text-black bg-white dark:bg-gray-700"
        >
            <slot
                name="inertia"
                :title="title"
                :sidebarFull="sidebarFull"
                :sidebarToggle="sidebarToggle"
                :drawerOpen="drawerOpen"
                :drawerToggle="drawerToggle"
                :searchBoxOpen="searchBoxOpen"
                :openSearchBox="openSearchBox"
                :closeSearchBox="closeSearchBox"
            >
                <Inertia
                    :title="title"
                    :sidebarFull="sidebarFull"
                    :sidebarToggle="sidebarToggle"
                    :drawerOpen="drawerOpen"
                    :drawerToggle="drawerToggle"
                    :searchBoxOpen="searchBoxOpen"
                    :openSearchBox="openSearchBox"
                    :closeSearchBox="closeSearchBox"
                />
            </slot>

            <main
                :class="{ 'lg:ml-60': sidebarFull }"
                class="flex flex-col flex-1 ml-0 mt-14 mb-14 sm:mb-10 sm:ml-10"
            >
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<style lang="scss">
@import "../../css/panel.scss";
</style>
