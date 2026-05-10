<template>
  <nav class="navbar" :class="{ 'navbar-scrolled': scrolled }">
    <div class="nav-shell">
      <div class="nav-panel">
        <a href="#top" class="nav-logo" @click="mobileOpen = false">
          <span class="logo-icon"><i class="fas fa-gem"></i></span>
          <span class="logo-text">
            <strong>دهب سوفتوير</strong>
            <small>حلول رقمية بهوية أنيقة</small>
          </span>
        </a>

        <ul class="nav-links">
          <li><a href="#about" class="nav-link">من نحن</a></li>
          <li><a href="#services" class="nav-link">الخدمات</a></li>
          <li><a href="#portfolio" class="nav-link">الأعمال</a></li>
          <li><a href="#why-us" class="nav-link">لماذا نحن</a></li>
          <li><a href="#contact" class="nav-link">تواصل</a></li>
        </ul>

        <div class="nav-actions">
          <a href="#portfolio" class="btn-outline-gold">استعراض الأعمال</a>
          <a href="#contact" class="btn-gold">ابدأ مشروعك</a>
        </div>

        <button class="mobile-toggle" type="button" @click="mobileOpen = !mobileOpen">
          <i :class="mobileOpen ? 'fas fa-xmark' : 'fas fa-bars'"></i>
        </button>
      </div>
    </div>

    <div class="mobile-menu" :class="{ open: mobileOpen }">
      <div class="mobile-menu-inner">
        <a href="#about" class="nav-link" @click="mobileOpen = false">من نحن</a>
        <a href="#services" class="nav-link" @click="mobileOpen = false">الخدمات</a>
        <a href="#portfolio" class="nav-link" @click="mobileOpen = false">الأعمال</a>
        <a href="#why-us" class="nav-link" @click="mobileOpen = false">لماذا نحن</a>
        <a href="#contact" class="nav-link" @click="mobileOpen = false">تواصل</a>
        <a href="#contact" class="btn-gold" @click="mobileOpen = false">اطلب عرضاً الآن</a>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const scrolled = ref(false)
const mobileOpen = ref(false)

const handleScroll = () => {
  scrolled.value = window.scrollY > 24
}

onMounted(() => window.addEventListener('scroll', handleScroll))
onUnmounted(() => window.removeEventListener('scroll', handleScroll))
</script>

<style scoped>
.navbar {
  position: fixed;
  inset: 0 0 auto 0;
  z-index: 1000;
  padding: 1.15rem 0;
  transition: padding 0.25s ease;
}

.navbar-scrolled {
  padding: 0.8rem 0;
}

.nav-shell {
  width: min(1180px, calc(100% - 1.5rem));
  margin: 0 auto;
}

.nav-panel {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  border-radius: 24px;
  border: 1px solid rgba(255, 255, 255, 0.08);
  background: rgba(5, 8, 22, 0.58);
  backdrop-filter: blur(16px);
  padding: 0.85rem 1rem;
  box-shadow: 0 18px 50px rgba(0, 0, 0, 0.24);
}

.nav-logo {
  display: inline-flex;
  align-items: center;
  gap: 0.8rem;
  color: #fff;
  text-decoration: none;
}

.logo-icon {
  width: 48px;
  height: 48px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 16px;
  color: #090909;
  background: linear-gradient(135deg, #f0c240, #b8831d);
  box-shadow: 0 10px 24px rgba(240, 194, 64, 0.18);
}

.logo-text {
  display: flex;
  flex-direction: column;
  line-height: 1.2;
}

.logo-text strong {
  font-size: 1rem;
}

.logo-text small {
  color: #8e96ac;
  font-size: 0.72rem;
  margin-top: 0.18rem;
}

.nav-links {
  display: flex;
  align-items: center;
  gap: 1.6rem;
  list-style: none;
  margin: 0;
  padding: 0;
}

.nav-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.mobile-toggle {
  display: none;
  width: 44px;
  height: 44px;
  border-radius: 14px;
  border: 1px solid rgba(255, 255, 255, 0.08);
  background: rgba(255, 255, 255, 0.04);
  color: #fff;
}

.mobile-menu {
  width: min(1180px, calc(100% - 1.5rem));
  margin: 0.75rem auto 0;
  max-height: 0;
  overflow: hidden;
  opacity: 0;
  transition: max-height 0.22s ease, opacity 0.22s ease;
}

.mobile-menu.open {
  max-height: 420px;
  opacity: 1;
}

.mobile-menu-inner {
  display: flex;
  flex-direction: column;
  gap: 0.7rem;
  border-radius: 24px;
  border: 1px solid rgba(255, 255, 255, 0.08);
  background: rgba(5, 8, 22, 0.94);
  padding: 1rem;
}

.mobile-menu-inner .nav-link {
  padding: 0.8rem 0.2rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.mobile-menu-inner .nav-link:last-of-type {
  border-bottom: none;
}

@media (max-width: 960px) {
  .nav-links,
  .nav-actions {
    display: none;
  }

  .mobile-toggle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
}
</style>
