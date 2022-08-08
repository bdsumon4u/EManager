import { onMounted, ref, watch } from "vue";
import { useEventListener } from "@vueuse/core";

export function useScreen() {
    const windowWidth = ref(window.innerWidth);
    const screenType = ref(window.screenType);

    const breakpoints = {
        "2xl": 1536,
        xl: 1280,
        lg: 1024,
        md: 768,
        sm: 640,
        xs: 0,
    };

    const onResize = () => {
        windowWidth.value = window.innerWidth;
        for (const device in breakpoints) {
            if (isDevice(device)) {
                return (screenType.value = device);
            }
        }
    };

    const isDevice = (size) => {
        return windowWidth.value >= breakpoints[size];
    };

    onMounted(onResize);
    useEventListener(window, "resize", onResize);
    watch(screenType, (newV) => (window.screenType = newV));

    return {
        breakpoints,
        isDevice,
        onResize,
        screenType,
        windowWidth,
    };
}
