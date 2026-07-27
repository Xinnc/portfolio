import { ref } from 'vue'
import { categories } from '@/api/endpoints'

export function useCategories() {

    const categoryItems = ref([])
    const loading = ref(false)
    const submitting = ref(false)
    const submitError = ref({})

    const fetchCategories = async () => {
        loading.value = true

        try {
            const { data } = await categories.getPublic()
            categoryItems.value = data.data
        } finally {
            loading.value = false
        }
    }

    const adminFetchCategories = async () => {
        loading.value = true

        try {
            const {data} = await categories.getAll()
            categoryItems.value = data.data
        } finally {
            loading.value = false
        }
    }

    const adminCreateCategories = async (formData) => {
        submitting.value = true
        submitError.value = {}

        try {
            const {data} = await categories.create(formData)
            return {success: true, data: data.data}
        } catch (e) {
            const response = e.response?.data
            submitError.value = response.errors ?? {general: response?.message || 'Произошла непредвиденная ошибка'}
            setTimeout(() => {
                submitError.value = {}
            }, 5000)
        } finally {
            submitting.value = false
        }
    }

    const adminUpdateCategories = async (index, formData) => {
        submitting.value = true
        submitError.value = {}

        try {
            const {data} = await categories.update(index, formData)
            return {success: true, data: data.data}
        } catch (e) {
            const response = e.response?.data
            submitError.value = response?.errors ?? {general: [response?.message || 'Произошла непредвиденная ошибка']}
            setTimeout(() => {
                submitError.value = {}
            }, 5000)
        } finally {
            submitting.value = false
        }
    }

    const adminDeleteCategories = async (index) => {
        submitting.value = true
        submitError.value = {}

        try {
            const {data} = await categories.delete(index)
            return {success: true, data: data.data}
        } catch (e) {
            const response = e.response?.data
            submitError.value = response?.errors ?? {general: [response?.message || 'Произошла непредвиденная ошибка']}
            setTimeout(() => {
                submitError.value = {}
            }, 5000)
        } finally {
            submitting.value = false
        }
    }

    return {
        categoryItems,
        loading,
        fetchCategories,

        adminFetchCategories,
        submitting,
        submitError,
        adminCreateCategories,
        adminUpdateCategories,
        adminDeleteCategories
    }

}