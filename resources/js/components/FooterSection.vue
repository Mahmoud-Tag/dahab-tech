<template>
  <footer class="footer">
    <div class="footer-inner">
      <div class="footer-brand">
        <div class="footer-logo">
          <span class="logo-icon-sm"><i class="fas fa-gem"></i></span>
          <div>
            <strong>دهب سوفتوير</strong>
            <p>تطوير، تصميم، أنظمة، ومتاجر رقمية بطابع أكثر أناقة.</p>
          </div>
        </div>
      </div>

      <div class="footer-copy">
        © {{ year }} دهب سوفتوير. جميع الحقوق محفوظة.
      </div>
    </div>
  </footer>
</template>

<script setup>
const year = new Date().getFullYear()
</script>

<style scoped>
.footer {
  padding: 2.6rem 0 3rem;
  border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.footer-inner {
  width: min(1180px, calc(100% - 2rem));
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  flex-wrap: wrap;
  color: #8e96ac;
}

.footer-logo {
  display: flex;
  align-items: center;
  gap: 0.85rem;
}

.logo-icon-sm {
  width: 42px;
  height: 42px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 14px;
  color: #090909;
  background: linear-gradient(135deg, #f0c240, #b8831d);
}

.footer-logo strong {
  display: block;
  color: #fff;
}

.footer-logo p {
  margin: 0.2rem 0 0;
}
</style>
