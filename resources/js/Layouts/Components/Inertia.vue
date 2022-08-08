<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import Banner from "./Banner.vue";
import Drawer from "./Drawer.vue";
import Footer from "./Footer.vue";
import Header from "./Header.vue";
import SearchBox from "./SearchBox.vue";
import Sidebar from "./Sidebar.vue";

defineProps({
    title: String,
    sidebarFull: Boolean,
    sidebarToggle: Function,
    drawerOpen: Boolean,
    drawerToggle: Function,
    searchBoxOpen: Boolean,
    openSearchBox: Function,
    closeSearchBox: Function,
});
</script>

<template>
    <Head :title="title" />

    <Banner />

    <div
        v-show="sidebarFull"
        @click="sidebarToggle"
        class="fixed inset-0 z-10 w-screen h-screen bg-black bg-opacity-25 sm:hidden"
    ></div>
    <div
        v-show="drawerOpen"
        @click="drawerToggle"
        class="fixed inset-0 z-50 w-screen h-screen bg-black bg-opacity-25 sm:hidden"
    ></div>
    <slot
        name="header"
        :sidebarToggle="sidebarToggle"
        :openSearchBox="openSearchBox"
        :drawerToggle="drawerToggle"
    >
        <Header
            :sidebarToggle="sidebarToggle"
            :openSearchBox="openSearchBox"
            :drawerToggle="drawerToggle"
        />
    </slot>
    <slot
        name="sidebar"
        :sidebarFull="sidebarFull"
        :sidebarToggle="sidebarToggle"
    >
        <Sidebar :sidebarFull="sidebarFull" :sidebarToggle="sidebarToggle" />
    </slot>
    <slot name="drawer">
        <Drawer :drawerOpen="drawerOpen" :drawerToggle="drawerToggle" />
    </slot>
    <slot name="footer">
        <Footer
            :sidebarToggle="sidebarToggle"
            :openSearchBox="openSearchBox"
            :drawerToggle="drawerToggle"
        />
    </slot>
    <slot name="search-box">
        <SearchBox
            id="search-modal"
            searchId="search"
            :searchBoxOpen="searchBoxOpen"
            :openSearchBox="openSearchBox"
            :closeSearchBox="closeSearchBox"
        />
    </slot>
</template>
