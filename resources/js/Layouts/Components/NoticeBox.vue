<script setup>
import { BellIcon } from "@heroicons/vue/outline";
import { ref } from "vue";
import { useEscOrOutside } from "../../composables/useEscOrOutside";

const open = ref(false);
const container = ref(null);

const notifications = ref({
    unread: 2,
    latest: [
        {
            id: 1,
            message: "The fifth notification.",
            created_at: "20-Jul-2022 04:30 PM",
            read_at: "20-Jul-2022 04:30 PM",
        },
        {
            id: 2,
            message: "The fourth notification.",
            created_at: "20-Jul-2022 04:30 PM",
        },
        {
            id: 3,
            message: "The third notification.",
            created_at: "20-Jul-2022 04:30 PM",
            read_at: "20-Jul-2022 04:30 PM",
        },
        {
            id: 4,
            message: "The second notification.",
            created_at: "20-Jul-2022 04:30 PM",
        },
        {
            id: 5,
            message: "The very first notification.",
            created_at: "20-Jul-2022 04:30 PM",
            read_at: "20-Jul-2022 04:30 PM",
        },
    ],
});

useEscOrOutside(container, () => (open.value = false));
</script>

<template>
    <div ref="container">
        <button
            @click="open = !open"
            class="relative grid w-10 h-10 text-blue-400 bg-gray-100 rounded-md dark:text-gray-200 dark:bg-gray-500 hover:text-blue-600 hover:bg-blue-100 place-content-center focus:outline-none focus:ring"
        >
            <BellIcon class="w-5 h-5" />
            <span
                class="absolute w-5 h-5 text-sm text-white bg-red-500 rounded-md -top-1 -right-2"
                >{{ notifications.unread }}</span
            >
        </button>

        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <div
                v-show="open"
                class="absolute right-0 z-50 mt-2 -mr-16 origin-top-right rounded-md shadow-lg w-72 md:mr-0"
                style="display: none"
            >
                <div
                    class="py-1 bg-white rounded-md ring-1 ring-black ring-opacity-5 dark:bg-black dark:text-gray-200"
                >
                    <div class="right-0 z-10">
                        <div class="px-4 py-2 text-sm font-bold uppercase">
                            Notifications
                        </div>
                        <ul class="px-2 py-1">
                            <li
                                v-for="notification in notifications.latest"
                                class="my-1 rounded-sm hover:bg-gray-200"
                                :class="[
                                    notification.read_at
                                        ? 'bg-gray-100'
                                        : 'bg-yellow-100',
                                ]"
                                :key="notification.id"
                            >
                                <a href="" class="block px-2 py-2 nc">
                                    <span class="block mb-2 text-sm"
                                        >📣
                                        <span class="text-gray-800 rx">{{
                                            notification.message
                                        }}</span></span
                                    >
                                    <span
                                        class="block text-xs text-black opacity-75 font-weight-500"
                                        >{{ notification.created_at }}</span
                                    >
                                </a>
                            </li>
                            <li
                                v-if="notifications.latest.length > 3"
                                class="flex items-center justify-center"
                            >
                                <small class="-mt-1 text-xs">.......</small>
                            </li>
                            <li class="flex space-x-1">
                                <strong
                                    v-if="!notifications.latest.length"
                                    class="w-full p-2 text-red-500 border dark:border-gray-500"
                                    >Nothing Found.</strong
                                >
                                <Link
                                    v-if="notifications.unread > 0"
                                    class="grid w-full p-2 text-sm font-bold bg-gray-200 rounded-sm hover:bg-gray-300 dark:text-gray-800 place-content-center"
                                    >Mark All As Read
                                </Link>
                                <Link
                                    v-if="notifications.latest.length > 3"
                                    class="grid w-full p-2 text-sm font-bold bg-gray-200 rounded-sm hover:bg-gray-300 dark:text-gray-800 place-content-center"
                                    >View All
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
