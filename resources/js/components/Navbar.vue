<template>
  <nav class="navbar" :class="{ 'navbar-scrolled': scrolled }">
    <div class="nav-container">
      <!-- Logo -->
      <div class="nav-logo">
        <div class="logo-icon">
          <i class="fas fa-code"></i>
        </div>
        <div class="logo-text">
          <span class="logo-main">دهب سوفتوير</span>
          <span class="logo-sub">للحلول البرمجية</span>
        </div>
      </div>

      <!-- Links -->
      <ul class="nav-links">
        <li><a href="#about" class="nav-link">من نحن</a></li>
        <li><a href="#services" class="nav-link">خدماتنا</a></li>
        <li><a href="#portfolio" class="nav-link">أعمالنا</a></li>
        <li><a href="#why-us" class="nav-link">لماذا نحن؟</a></li>
        <li><a href="#contact" class="nav-link">تواصل معنا</a></li>
      </ul>

      <!-- CTA -->
      <a href="#contact" class="btn-gold nav-cta">
        <i class="fas fa-paper-plane"></i>
        اطلب عرض سعر
      </a>

      <!-- Mobile toggle -->
      <button class="mobile-toggle" @click="mobileOpen = !mobileOpen">
        <i :class="mobileOpen ? 'fas fa-times' : 'fas fa-bars'"></i>
      </button>
    </div>

    <!-- Mobile menu -->
    <div class="mobile-menu" :class="{ open: mobileOpen }">
      <a href="#about" class="nav-link" @click="mobileOpen = false">من نحن</a>
      <a href="#services" class="nav-link" @click="mobileOpen = false">خدماتنا</a>
      <a href="#portfolio" class="nav-link" @click="mobileOpen = false">أعمالنا</a>
      <a href="#why-us" class="nav-link" @click="mobileOpen = false">لماذا نحن؟</a>
      <a href="#contact" class="nav-link" @click="mobileOpen = false">تواصل معنا</a>
      <a href="#contact" class="btn-gold" style="margin-top:1rem;" @click="mobileOpen = false">اطلب عرض سعر</a>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const scrolled = ref(false)
const mobileOpen = ref(false)

const handleScroll = () => { scrolled.value = window.scrollY > 50 }
onMounted(() => window.addEventListener('scroll', handleScroll))
onUnmounted(() => window.removeEventListener('scroll', handleScroll))
</script>

<style scoped>
.navbar {
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000;
  padding: 1rem 0;
  transition: all 0.4s ease;
  background: transparent;
}

.navbar-scrolled {
  background: rgba(10, 10, 10, 0.95);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border-bottom: 1px solid rgba(201, 162, 39, 0.2);
  padding:  0;
  box-shadow: 0 4px 30px rgba(0,0,0,0.4);
}

.nav-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0.2rem 2rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 2rem;
}

.nav-logo {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  text-decoration: none;
  flex-shrink: 0;
}

.logo-icon {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, #f0c240, #c9a227);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.3rem;
  color: #000;
  box-shadow: 0 4px 15px rgba(201,162,39,0.4);
}

.logo-text { display: flex; flex-direction: column; line-height: 1.1; }
.logo-main { font-size: 1.1rem; font-weight: 800; color: #f0c240; }
.logo-sub { font-size: 0.65rem; color: #888; font-weight: 400; }

.nav-links {
  display: flex;
  list-style: none;
  gap: 2.5rem;
  margin: 0;
  padding: 0;
}

.nav-cta { font-size: 0.9rem; padding: 0.6rem 1.3rem; }

.mobile-toggle {
  display: none;
  background: none;
  border: 1px solid rgba(201,162,39,0.4);
  color: #f0c240;
  font-size: 1.2rem;
  padding: 0.4rem 0.7rem;
  border-radius: 6px;
  cursor: pointer;
}

.mobile-menu {
  display: flex;
  flex-direction: column;
  background: rgba(10,10,10,0.98);
  border-top: 1px solid rgba(201,162,39,0.15);
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.4s ease, padding 0.4s ease;
  padding: 0 2rem;
}

.mobile-menu.open {
  max-height: 400px;
  padding: 1.5rem 2rem 2rem;
}

.mobile-menu .nav-link {
  padding: 0.8rem 0;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  font-size: 1.05rem;
  width: 100%;
}

.mobile-menu .nav-link:last-of-type {
  border-bottom: none;
}

@media (max-width: 900px) {
  .nav-links { display: none; }
  .nav-cta { display: none; }
  .mobile-toggle { display: block; }
}
</style>
