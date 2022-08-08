import { useEventListener } from "@vueuse/core";
import { onMounted, ref, watch } from "vue";
import { useScreen } from "./useScreen";

export function useSidebar() {
    const openId = ref(null);
    const { isDevice } = useScreen();
    const sidebarFull = ref(window.sidebarFull);

    const sidebarToggle = () => {
        sidebarFull.value = !sidebarFull.value;
    };

    const adjastDevice = () => {
        return (sidebarFull.value = isDevice("lg"));
    };

    const setSidebarHeight = () => {
        const target = document.querySelector(".sidebar > div > ul");
        const px = document.body.scrollHeight - 3.5 * 16;
        target.style.height = px / 16 + "rem";
    };

    const isOpen = (item_id) => {
        return openId.value === item_id;
    };

    const doOpen = (item_id) => {
        openId.value = isOpen(item_id) ? null : item_id;
    };

    const hasSub = (item) => {
        let _class = "";
        if (item.children) {
            _class += "has-sub";
            if (openId.value === item.id) {
                _class += " open";
            }
        }
        return _class;
    };

    const isActive = (item) => {
        if (item.active?.length) {
            return routeIn(item.active ?? []);
        }

        let href = item.href;
        if (href && !href.startsWith(location.origin)) {
            href = location.origin + href;
        }
        return location.href === href;
    };

    const routeIn = (active) => {
        return active.some((item) => route().current(item));
    };

    onMounted(() => {
        adjastDevice(); // onCreated
        setSidebarHeight(); // onMounted
    });

    useEventListener(window, "resize", () => {
        adjastDevice();
        setSidebarHeight();
    });

    watch(sidebarFull, (newV) => (window.sidebarFull = newV));

    return {
        doOpen,
        isOpen,
        hasSub,
        isActive,
        sidebarFull,
        sidebarToggle,
    };
}
