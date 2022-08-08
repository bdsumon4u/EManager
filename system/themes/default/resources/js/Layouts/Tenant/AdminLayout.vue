<script setup>
import Header from "@/Layouts/Components/Header.vue";
import Inertia from "@/Layouts/Components/Inertia.vue";
import Sidebar from "@/Layouts/Components/Sidebar.vue";
import PanelLayout from "@/Layouts/PanelLayout.vue";
import { HomeIcon } from "@heroicons/vue/outline";
const props = defineProps({
    title: String,
});
const items = [
    {
        id: "dashboard",
        name: "Dashboard",
        icon: HomeIcon,
        href: route("tenant.admin.dashboard"),
    },
];
</script>

<template>
    <PanelLayout :title="title">
        <template
            #inertia="{
                sidebarFull,
                sidebarToggle,
                drawerOpen,
                drawerToggle,
                searchBoxOpen,
                openSearchBox,
                closeSearchBox,
            }"
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
            >
                <template
                    #header="{ sidebarToggle, openSearchBox, drawerToggle }"
                >
                    <Header
                        :sidebarToggle="sidebarToggle"
                        :openSearchBox="openSearchBox"
                        :drawerToggle="drawerToggle"
                    >
                        <template #branding>
                            <img
                                @click.prevent="
                                    $inertia.visit(
                                        route('tenant.admin.dashboard')
                                    )
                                "
                                class="w-40 h-12 cursor-pointer sm:w-56 lg:w-44"
                                src="/storage/logo.png"
                                alt="Branding"
                            />
                        </template>
                        <template #header> </template>
                    </Header>
                </template>
                <template #sidebar="{ sidebarFull, sidebarToggle }">
                    <Sidebar
                        :items="items"
                        :key="Math.random()"
                        :sidebarFull="sidebarFull"
                        :sidebarToggle="sidebarToggle"
                    />
                </template>
            </Inertia>
        </template>
        <slot></slot>
    </PanelLayout>
</template>
