import {ref, computed, onMounted} from 'vue';

export function useSessionInformations() {

    const user = ref(null);

    onMounted(async () => {
        try {
            const response = await axios.get('/session/informations');
            user.value = response.data;
        } catch (error) {
            user.value = null;
        }
    });

    const isAuthenticated = computed(() => user?.value?.id > 0);
    const isAdmin = computed(() => isAuthenticated && user?.value?.role === 'admin');

    return { user, isAuthenticated, isAdmin };

}
