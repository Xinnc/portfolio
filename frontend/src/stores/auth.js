import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { auth } from '@/api/endpoints'

export const useAuthStore = defineStore('auth', () => {

    const token = ref(localStorage.getItem('token'))
    const user = ref(null)
    const isAuthenticated = computed(() => !!token.value)
    const isAdmin = ref(false)
    const login = async (credentials) => {
        try {
            const response = await auth.info()
            isAdmin.value = response.data
            return true
        } catch (e) {
            token.value = null
            isAdmin.value = false
            localStorage.removeItem('token')
            return false
        }
    }

    const checkLogin = async () => {
        const response = await auth.info()
        checkToken.value = response.data
        return response
    }

    const logout = async () => {
        await auth.logout()
        token.value = null
        user.value = null
        localStorage.removeItem('token')
    }

    return {
        token,
        user,
        isAuthenticated,
        login,
        logout,
        checkLogin,
        isAdmin,
    }

})