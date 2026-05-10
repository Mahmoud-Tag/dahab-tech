<template>
  <div class="login-page">
    <!-- Animated background particles/shapes could be added here -->
    <div class="login-container" data-aos="zoom-in">
      <div class="login-card">
        <div class="brand-section">
          <div class="logo-circle">
            <i class="fas fa-user-shield"></i>
          </div>
          <h2 class="title">بوابة المشرف</h2>
          <p class="subtitle">سجل الدخول لإدارة لوحة تحكم دهب</p>
        </div>

        <div v-if="errorMsg" class="error-alert" @click="errorMsg = ''">
          <i class="fas fa-exclamation-triangle"></i>
          <span>{{ errorMsg }}</span>
        </div>

        <form @submit.prevent="login" class="login-form">
          <div class="input-group">
            <label>البريد الإلكتروني</label>
            <div class="input-wrapper">
              <i class="fas fa-envelope"></i>
              <input 
                v-model="form.email" 
                type="email" 
                placeholder="admin@example.com"
                required
              >
            </div>
          </div>

          <div class="input-group">
            <label>كلمة المرور</label>
            <div class="input-wrapper">
              <i class="fas fa-lock"></i>
              <input 
                v-model="form.password" 
                type="password" 
                placeholder="••••••••"
                required
              >
            </div>
          </div>

          <button type="submit" class="btn-primary" :disabled="loading">
            <span v-if="loading" class="loader"></span>
            <span v-else>تسجيل الدخول</span>
            <i v-if="!loading" class="fas fa-sign-in-alt"></i>
          </button>
        </form>

        <div class="card-footer">
          <p>جميع الحقوق محفوظة &copy; {{ new Date().getFullYear() }} دهب سوفتوير</p>
        </div>
      </div>
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
const errorMsg = ref('')

const login = async () => {
  loading.value = true
  errorMsg.value = ''
  try {
    const { data } = await axios.post('/api/login', form.value)
    localStorage.setItem('admin_token', data.token)
    router.push('/admin/dashboard')
  } catch (err) {
    errorMsg.value = 'بيانات الدخول غير صحيحة. يرجى المحاولة مرة أخرى.'
    console.error('Login error:', err)
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: radial-gradient(circle at center, #1a1a1a 0%, #000 100%);
  font-family: 'Cairo', sans-serif;
  overflow: hidden;
  position: relative;
}

.login-page::before {
  content: '';
  position: absolute;
  width: 150vw;
  height: 150vh;
  background: radial-gradient(circle at center, rgba(234, 179, 8, 0.05) 0%, transparent 70%);
  animation: pulse 10s infinite alternate;
}

@keyframes pulse {
  0% { transform: scale(1); opacity: 0.5; }
  100% { transform: scale(1.1); opacity: 0.8; }
}

.login-container {
  width: 100%;
  max-width: 440px;
  padding: 2rem;
  position: relative;
  z-index: 10;
}

.login-card {
  background: rgba(17, 17, 17, 0.7);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(234, 179, 8, 0.15);
  border-radius: 2.5rem;
  padding: 3rem 2.5rem;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5),
              0 0 40px rgba(234, 179, 8, 0.03);
}

.brand-section {
  text-align: center;
  margin-bottom: 2.5rem;
}

.logo-circle {
  width: 70px;
  height: 70px;
  background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);
  border-radius: 1.25rem;
  margin: 0 auto 1.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.8rem;
  color: #000;
  box-shadow: 0 10px 25px rgba(234, 179, 8, 0.3);
  transform: rotate(-5deg);
}

.title {
  font-size: 1.8rem;
  font-weight: 800;
  color: #fff;
  margin-bottom: 0.5rem;
}

.subtitle {
  color: #666;
  font-size: 0.9rem;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.input-group {
  display: flex;
  flex-direction: column;
  gap: 0.6rem;
}

.input-group label {
  font-size: 0.85rem;
  font-weight: 600;
  color: #888;
  margin-right: 0.5rem;
}

.input-wrapper {
  position: relative;
}

.input-wrapper i {
  position: absolute;
  right: 1.25rem;
  top: 50%;
  transform: translateY(-50%);
  color: #555;
  transition: color 0.3s;
}

.input-wrapper input {
  width: 100%;
  background: rgba(0,0,0,0.3);
  border: 1.5px solid rgba(255,255,255,0.05);
  border-radius: 1.25rem;
  padding: 1rem 3.2rem 1rem 1.25rem;
  color: #fff;
  font-size: 1rem;
  transition: all 0.3s ease;
  outline: none;
}

.input-wrapper input:focus {
  border-color: rgba(234, 179, 8, 0.4);
  background: rgba(0,0,0,0.5);
  box-shadow: 0 0 15px rgba(234, 179, 8, 0.05);
}

.input-wrapper input:focus + i {
  color: #eab308;
}

.btn-primary {
  margin-top: 1rem;
  background: #eab308;
  color: #000;
  border: none;
  border-radius: 1.25rem;
  padding: 1.1rem;
  font-size: 1.1rem;
  font-weight: 800;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.btn-primary:hover:not(:disabled) {
  background: #fff;
  transform: translateY(-3px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.4);
}

.btn-primary:active {
  transform: translateY(0);
}

.btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.error-alert {
  background: rgba(239, 68, 68, 0.1);
  border: 1px solid rgba(239, 68, 68, 0.2);
  color: #ef4444;
  padding: 1rem;
  border-radius: 1rem;
  margin-bottom: 1.5rem;
  font-size: 0.85rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  cursor: pointer;
  animation: shake 0.4s ease-in-out;
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  75% { transform: translateX(5px); }
}

.card-footer {
  text-align: center;
  margin-top: 2.5rem;
  font-size: 0.75rem;
  color: #444;
}

.loader {
  width: 20px;
  height: 20px;
  border: 2.5px solid rgba(0,0,0,0.2);
  border-top-color: #000;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

[dir="rtl"] .input-wrapper i {
  left: auto;
  right: 1.25rem;
}

[dir="rtl"] .input-wrapper input {
  padding-right: 3.2rem;
  padding-left: 1.25rem;
}
</style>
