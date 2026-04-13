<template>
  <div class="min-h-screen flex items-center justify-center bg-black font-['Cairo']">
    <div class="bg-gray-900 p-8 rounded-2xl border border-yellow-600/20 w-96 shadow-2xl">
      <h2 class="text-3xl font-bold text-yellow-500 mb-6 text-center">مشرف الموقع</h2>
      <form @submit.prevent="login" class="space-y-4">
        <div>
          <label class="block text-gray-400 text-sm mb-1">البريد الإلكتروني</label>
          <input v-model="form.email" type="email" class="w-full bg-black border border-gray-800 rounded-lg p-3 text-white focus:border-yellow-500 outline-none" required>
        </div>
        <div>
          <label class="block text-gray-400 text-sm mb-1">كلمة المرور</label>
          <input v-model="form.password" type="password" class="w-full bg-black border border-gray-800 rounded-lg p-3 text-white focus:border-yellow-500 outline-none" required>
        </div>
        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold p-3 rounded-lg transition" :disabled="loading">
          {{ loading ? 'جاري الدخول...' : 'دخول' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const form = ref({ email: '', password: '' })
const loading = ref(false)

const login = async () => {
  loading.value = true
  try {
    const { data } = await axios.post('/api/login', form.value)
    localStorage.setItem('admin_token', data.token)
    router.push('/admin/dashboard')
  } catch (err) {
    alert('بيانات الدخول غير صحيحة')
  } finally {
    loading.value = false
  }
}
</script>
