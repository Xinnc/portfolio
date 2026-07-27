import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { auth } from '@/api/endpoints'

export const useAuthStore = defineStore('auth', () => {

    const token = ref(localStorage.getItem('token'))
    const user = ref(null)
    const isAuthenticated = computed(() => !!token.value)

    const login = async (credentials) => {
        const response = await auth.login(credentials)
        token.value = response.data.token
        localStorage.setItem('token', token.value)
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
        logout
    }

})