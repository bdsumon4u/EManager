import { ref } from "vue";

export function useSearchBox() {
    const searchBoxOpen = ref(false);

    const openSearchBox = () => (searchBoxOpen.value = true);
    const closeSearchBox = () => (searchBoxOpen.value = false);

    return {
        searchBoxOpen,
        openSearchBox,
        closeSearchBox,
    };
}
