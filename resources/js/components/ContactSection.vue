<template>
  <section id="contact" class="contact">
    <div class="contact-container">
      <h2 class="section-title">تواصل معنا</h2>

      <div class="contact-grid">

        <!-- Contact info -->
        <div class="contact-info">
          <p class="contact-sub">نحن هنا لمساعدتك في تحقيق مشروعك. تواصل معنا الآن!</p>

          <div class="contact-details">
            <div class="contact-info-item">
              <i class="fas fa-phone"></i>
              <span dir="ltr">+20 1064147224</span>
            </div>
            <div class="contact-info-item">
              <i class="fas fa-envelope"></i>
              <span>info@dahabtech.com</span>
            </div>
            <div class="contact-info-item">
              <i class="fab fa-whatsapp"></i>
              <span>واتساب: 01064147224</span>
            </div>
          </div>

          <!-- Social links -->
          <div class="social-links">
            <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
          </div>
        </div>

        <!-- Form -->
        <form @submit.prevent="submitForm" class="contact-form">
          <div class="form-group">
            <label>الاسم الكامل</label>
            <input
              v-model="form.name"
              placeholder="أدخل اسمك الكامل"
              class="gold-input"
              required
            />
          </div>

          <div class="form-group">
            <label>البريد الإلكتروني</label>
            <input
              v-model="form.email"
              type="email"
              placeholder="أدخل بريدك الإلكتروني"
              class="gold-input"
              required
            />
          </div>

          <div class="form-group">
            <label>رسالتك</label>
            <textarea
              v-model="form.message"
              placeholder="أخبرنا عن مشروعك..."
              class="gold-input"
              rows="4"
              required
            ></textarea>
          </div>

          <button type="submit" class="btn-gold submit-btn" :disabled="submitting">
            <i :class="submitting ? 'fas fa-spinner fa-spin' : 'fas fa-paper-plane'"></i>
            {{ submitting ? 'جارٍ الإرسال...' : 'إرسال' }}
          </button>

          <div v-if="success" class="success-msg">
            <i class="fas fa-check-circle"></i> تم إرسال رسالتك بنجاح! سنتواصل معك قريبًا.
          </div>
        </form>

      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive, ref } from 'vue'
import axios from 'axios'

const form = reactive({ name: '', email: '', message: '' })
const submitting = ref(false)
const success = ref(false)

const submitForm = async () => {
  submitting.value = true
  try {
    await axios.post('/api/contact', form)
    success.value = true
    form.name = ''
    form.email = ''
    form.message = ''
    setTimeout(() => { success.value = false }, 5000)
  } catch (e) {
    alert('حدث خطأ، يرجى المحاولة مرة أخرى')
  } finally {
    submitting.value = false
  }
}
</script>

<style scoped>
.contact {
  padding: 6rem 0 4rem;
  background: #111111;
  position: relative;
}

.contact::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(201,162,39,0.4), transparent);
}

.contact-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 2rem;
}

.contact-grid {
  display: grid;
  grid-template-columns: 1fr 1.3fr;
  gap: 4rem;
  align-items: start;
}

.contact-sub {
  color: #888;
  line-height: 1.8;
  margin-bottom: 2rem;
}

.contact-details {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 2.5rem;
}

.social-links {
  display: flex;
  gap: 0.75rem;
}

.social-btn {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: rgba(201,162,39,0.1);
  border: 1px solid rgba(201,162,39,0.3);
  color: #f0c240;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  text-decoration: none;
  transition: all 0.3s;
}

.social-btn:hover {
  background: rgba(201,162,39,0.25);
  border-color: #f0c240;
  transform: translateY(-3px);
  box-shadow: 0 6px 15px rgba(201,162,39,0.2);
}

.contact-form {
  background: #0d0d0d;
  border: 1px solid rgba(201,162,39,0.2);
  border-radius: 20px;
  padding: 2.5rem;
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-group label {
  font-size: 0.9rem;
  font-weight: 600;
  color: #c9a227;
}

.submit-btn {
  width: 100%;
  justify-content: center;
  font-size: 1rem;
  padding: 0.9rem;
  margin-top: 0.5rem;
}

.submit-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
  transform: none;
}

.success-msg {
  background: rgba(34,197,94,0.1);
  border: 1px solid rgba(34,197,94,0.3);
  color: #4ade80;
  border-radius: 8px;
  padding: 0.75rem 1rem;
  font-size: 0.9rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

@media (max-width: 900px) {
  .contact-grid {
    grid-template-columns: 1fr;
    gap: 2.5rem;
  }
}

@media (max-width: 640px) {
  .contact-form {
    padding: 1.5rem;
  }
  .contact-sub {
    font-size: 0.95rem;
  }
}
</style>
