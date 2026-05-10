<template>
  <section id="contact" class="contact-section">
    <div class="contact-shell">
      <article class="contact-card contact-card--info">
        <span class="contact-kicker">تواصل معنا</span>
        <h2 class="section-title" style="text-align:right;">لنصمم صفحة أو منصة تليق بعلامتك.</h2>
        <p class="contact-description">
          أخبرنا بطبيعة المشروع، ما الذي تريد تحسينه، وما الذي يجب أن يشعر به العميل في أول زيارة.
          سنقترح عليك مسار تنفيذ واضح ومناسب لهوية عملك.
        </p>

        <div class="contact-points">
          <div class="contact-point">
            <small>الهاتف</small>
            <strong dir="ltr">+20 1064147224</strong>
          </div>
          <div class="contact-point">
            <small>البريد</small>
            <strong>info@dahabtech.com</strong>
          </div>
          <div class="contact-point">
            <small>واتساب</small>
            <strong dir="ltr">01064147224</strong>
          </div>
        </div>
      </article>

      <form @submit.prevent="submitForm" class="contact-card contact-form">
        <div class="form-grid">
          <label class="form-field">
            <span>الاسم الكامل</span>
            <input v-model="form.name" placeholder="اكتب اسمك الكامل" class="gold-input" required />
          </label>

          <label class="form-field">
            <span>البريد الإلكتروني</span>
            <input v-model="form.email" type="email" placeholder="name@example.com" class="gold-input" required />
          </label>
        </div>

        <label class="form-field">
          <span>تفاصيل المشروع</span>
          <textarea v-model="form.message" rows="6" placeholder="حدثنا عن المشروع، الأهداف، وأهم المزايا التي تريدها." class="gold-input" required></textarea>
        </label>

        <button type="submit" class="btn-gold submit-btn" :disabled="submitting">
          <i :class="submitting ? 'fas fa-spinner fa-spin' : 'fas fa-paper-plane'"></i>
          {{ submitting ? 'جاري الإرسال...' : 'إرسال الطلب' }}
        </button>

        <div v-if="success" class="feedback-note feedback-note--success">
          <i class="fas fa-check-circle"></i>
          تم استلام رسالتك بنجاح، وسنتواصل معك قريباً.
        </div>

        <div v-if="error" class="feedback-note feedback-note--error">
          <i class="fas fa-triangle-exclamation"></i>
          {{ error }}
        </div>
      </form>
    </div>
  </section>
</template>

<script setup>
import { reactive, ref } from 'vue'
import axios from 'axios'

const form = reactive({ name: '', email: '', message: '' })
const submitting = ref(false)
const success = ref(false)
const error = ref('')

const submitForm = async () => {
  submitting.value = true
  success.value = false
  error.value = ''

  try {
    await axios.post('/api/contact', form)
    success.value = true
    form.name = ''
    form.email = ''
    form.message = ''
    setTimeout(() => {
      success.value = false
    }, 5000)
  } catch (e) {
    console.error('Contact submit error:', e)
    error.value = 'حدث خطأ أثناء الإرسال. حاول مرة أخرى خلال لحظات.'
  } finally {
    submitting.value = false
  }
}
</script>

<style scoped>
.contact-section {
  padding: 6rem 0 4.5rem;
  position: relative;
}

.contact-shell {
  width: min(1180px, calc(100% - 2rem));
  margin: 0 auto;
  display: grid;
  grid-template-columns: 0.88fr 1.12fr;
  gap: 1.4rem;
}

.contact-card {
  border-radius: 30px;
  border: 1px solid rgba(255, 255, 255, 0.08);
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(14px);
  box-shadow: 0 22px 80px rgba(0, 0, 0, 0.28);
  padding: 1.6rem;
}

.contact-kicker {
  display: inline-flex;
  align-items: center;
  padding: 0.45rem 0.95rem;
  border-radius: 999px;
  background: rgba(240, 194, 64, 0.08);
  border: 1px solid rgba(240, 194, 64, 0.2);
  color: #f0c240;
  font-size: 0.8rem;
  letter-spacing: 0.12em;
}

.contact-description {
  color: #9ea7bc;
  line-height: 1.95;
}

.contact-points {
  display: grid;
  gap: 0.9rem;
  margin-top: 2rem;
}

.contact-point {
  padding: 1rem 1.1rem;
  border-radius: 22px;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.08);
}

.contact-point small,
.form-field span {
  display: block;
  margin-bottom: 0.5rem;
  color: #8e96ac;
}

.contact-point strong {
  color: #fff;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}

.form-field {
  display: block;
  margin-bottom: 1rem;
}

.submit-btn {
  width: 100%;
}

.submit-btn:disabled {
  opacity: 0.7;
  transform: none;
}

.feedback-note {
  display: flex;
  align-items: center;
  gap: 0.55rem;
  margin-top: 1rem;
  padding: 0.9rem 1rem;
  border-radius: 18px;
}

.feedback-note--success {
  background: rgba(34, 197, 94, 0.12);
  border: 1px solid rgba(34, 197, 94, 0.22);
  color: #a7f3d0;
}

.feedback-note--error {
  background: rgba(244, 63, 94, 0.12);
  border: 1px solid rgba(244, 63, 94, 0.22);
  color: #fecdd3;
}

@media (max-width: 960px) {
  .contact-shell {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 640px) {
  .form-grid {
    grid-template-columns: 1fr;
  }
}
</style>
