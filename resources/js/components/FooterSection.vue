<template>
  <footer class="footer">
    <div class="footer-inner">
      <!-- Logo & tagline -->
      <div class="footer-brand">
        <div class="footer-logo">
          <div class="logo-icon-sm"><i class="fas fa-code"></i></div>
          <span class="footer-logo-text">دهب سوفتوير</span>
        </div>
        <p class="footer-tagline">للتطوير، البرمجة، التصميم، التسويق الرقمي </p>
      </div>

      <div class="footer-copy">
        © {{ year }} دهب سوفتوير — جميع الحقوق محفوظة
      </div>
    </div>
  </footer>
</template>

<script setup>
const year = new Date().getFullYear()
</script>

<style scoped>
.footer {
  background: #080808;
  border-top: 1px solid rgba(201,162,39,0.15);
  padding: 2rem 0;
}

.footer-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 1rem;
}

.footer-brand { display: flex; flex-direction: column; gap: 0.25rem; }

.footer-logo {
  display: flex;
  align-items: center;
  gap: 0.6rem;
}

.logo-icon-sm {
  width: 34px;
  height: 34px;
  background: linear-gradient(135deg, #f0c240, #c9a227);
  border-radius: 7px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
  color: #000;
}

.footer-logo-text { font-weight: 800; color: #f0c240; font-size: 1rem; }
.footer-tagline { font-size: 0.7rem; color: #555; padding-right: 2.8rem; }

.footer-copy { color: #555; font-size: 0.85rem; }
</style>
