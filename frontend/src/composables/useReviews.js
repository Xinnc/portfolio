import { ref } from 'vue'
import { reviews } from '@/api/endpoints'

export function useReviews() {

    const reviewItems = ref([])
    const loading = ref(false)
    const submitting = ref(false)
    const submitError = ref(null)

    const fetchReviews = async () => {
        loading.value = true

        try {
            const { data } = await reviews.getPublic()
            reviewItems.value = data.data
        } finally {
            loading.value = false
        }
    }

    const submitReview = async (formData) => {
        submitting.value = true
        try {
            const { data } = await reviews.create(formData)
            return {success: true, data: data}
        } catch (e) {
            submitError.value = e.response?.data?.message || e.message || 'Произошла неизвестная ошибка'
            setTimeout(() => {
                submitError.value = null
            }, 5000)
            return {success: false, error: submitError}
        } finally {
            submitting.value = false
        }
    }

    const adminFetchReviews = async (filters = {}) => {
        loading.value = true

        try {
            const {data} = await reviews.getAll(filters)
            reviewItems.value = data.data
        } finally {
            loading.value = false
        }
    }

    const adminChangeStatus = async (id, status) => {
        submitting.value = true
        try {
            const {data} = await reviews.update(id, {status})
            return {success: true, data: data}
        } catch (e) {
            submitError.value = e.response?.data?.message || e.message || 'Произошла неизвестная ошибка'
            setTimeout(() => {
                submitError.value = null
            }, 5000)
            return {success: false, error: submitError}
        } finally {
            submitting.value = false
        }
    }

    return {
        reviewItems,
        loading,
        fetchReviews,

        submitting,
        submitError,
        submitReview,

        adminFetchReviews,
        adminChangeStatus
    }

}