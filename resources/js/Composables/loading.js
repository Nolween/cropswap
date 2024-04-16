import {ref, computed} from 'vue';

export function useLoading() {
    const loading = ref(false);
    const setLoading = (value) => {
        loading.value = value;
    }

    const isLoading = computed(() => {
        return loading.value;
    });

    return {loading, setLoading, isLoading};
}
