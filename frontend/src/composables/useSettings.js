import { ref } from 'vue'
import { settings } from '@/api/endpoints'

export function useSettings() {

    const settingItems = ref([])
    const loading = ref(false)
    const submitting = ref(false)
    const submittingError = ref(null)

    const fetchSettings = async () => {
        loading.value = true

        try {
            const { data } = await settings.get()
            settingItems.value = data.data[0]
        } finally {
            loading.value = false
        }
    }

    const updateSettings = async (formData) => {
        submitting.value = true
        try {
            const { data } = await settings.update(formData)
            return {success: true, data: data}
        } catch (e) {
            submittingError.value = e.response?.data?.message || e.message || 'Произошла неизвестная ошибка'
            setTimeout(() => {
                submittingError.value = null
            }, 5000)
            return {success: false, error: submittingError }
        } finally {
            submitting.value = false
        }
    }

    return {
        settingItems,
        loading,
        fetchSettings,
        submitting,
        submittingError,
        updateSettings
    }

}