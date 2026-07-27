import { ref } from 'vue'
import {categories, projects} from '@/api/endpoints'

export function useProjects() {

    const projectItems = ref([])
    const categoryTitle = ref('')
    const loading = ref(false)
    const submitting = ref(false)
    const submitError = ref({})
    const mediaItems = ref([])


    const fetchProjects = async (categorySlug, filters = {}) => {
        loading.value = true

        try {
            const { data } = await projects.getByCategory(categorySlug, filters)
            projectItems.value = data.project.data || []
            categoryTitle.value = data.category
        } catch(e){
            projectItems.value = []
        } finally {
            loading.value = false
        }
    }

    const adminCreateProjects = async (index, formData) => {
        submitting.value = true
        submitError.value = {}

        try {
            const {data} = await projects.create(index, formData)
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

    const adminUpdateProjects = async (index, formData) => {
        submitting.value = true
        submitError.value = {}

        try {
            const {data} = await projects.update(index, formData)
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

    const adminDeleteProjects = async (index) => {
        submitting.value = true
        submitError.value = {}

        try {
            const {data} = await projects.delete(index)
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

    const adminAddMedia = async (index, formData) => {
        submitting.value = true
        submitError.value = {}

        try {
            const {data} = await projects.addMedia(index, formData)
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

    const adminDeleteMedia = async (index) => {
        submitting.value = true
        submitError.value = {}

        try {
            const {data} = await projects.deleteMedia(index)
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

    const adminGetMedia = async (index) => {
        loading.value = true

        try {
            const { data } = await projects.getMedia(index)
            mediaItems.value = data.message || []
        } catch(e){
            mediaItems.value = []
        } finally {
            loading.value = false
        }
    }

    return {
        projectItems,
        categoryTitle,
        loading,
        fetchProjects,
        mediaItems,
        adminGetMedia,

        submitting,
        submitError,
        adminCreateProjects,
        adminUpdateProjects,
        adminDeleteProjects,
        adminAddMedia,
        adminDeleteMedia,
    }

}