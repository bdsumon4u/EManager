<script setup>
import Welcome from "@/Jetstream/Welcome.vue";
</script>

<template>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <Welcome />
            </div>
        </div>
    </div>
</template>

<script>
import AdminLayout from "%/default/resources/js/Layouts/AdminLayout.vue";

const props = {
    title: "Dashboard",
};

export default {
    layout: (h, page) => {
        return h(AdminLayout, props, () => page);
    },
};
</script>
