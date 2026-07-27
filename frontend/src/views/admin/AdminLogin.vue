<script setup>
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth.js'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()
const email = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)

const handleLogin = async () => {
  if (!email.value || !password.value) {
    error.value = 'Заполните все поля'
    return
  }
  loading.value = true
  error.value = ''
  try {
    await authStore.login({ email: email.value, password: password.value })
    router.push('/admin')
  } catch (e) {
    error.value = e.response?.data?.message || 'Ошибка входа'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="login-page">
    <div class="login-card">
      <h2>Вход в админку</h2>
      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label>Email</label>
          <input v-model="email" type="email" required />
        </div>
        <div class="form-group">
          <label>Пароль</label>
          <input v-model="password" type="password" required />
        </div>
        <button type="submit" :disabled="loading" class="btn">
          {{ loading ? 'Вход...' : 'Войти' }}
        </button>
        <p v-if="error" class="error">{{ error }}</p>
      </form>
    </div>
  </div>
</template>

<style scoped>
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #0a0a0a;
}
.login-card {
  background: #1a1a1a;
  padding: 40px;
  border-radius: 16px;
  width: 100%;
  max-width: 400px;
  border: 1px solid #333;
}
.login-card h2 {
  text-align: center;
  margin-bottom: 30px;
  font-weight: 300;
  letter-spacing: 1px;
}
.form-group {
  margin-bottom: 20px;
}
.form-group label {
  display: block;
  margin-bottom: 6px;
  font-size: 14px;
  font-weight: 500;
}
.form-group input {
  width: 100%;
  padding: 12px;
  background: #0a0a0a;
  border: 1px solid #333;
  color: #fff;
  border-radius: 8px;
  outline: none;
}
.btn {
  width: 100%;
  padding: 14px;
  background: #fff;
  color: #0a0a0a;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
}
.btn:hover:not(:disabled) {
  background: #ccc;
}
.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
.error {
  margin-top: 12px;
  color: #f44336;
  text-align: center;
}
</style>