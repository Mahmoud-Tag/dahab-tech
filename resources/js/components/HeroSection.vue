<template>
  <section class="hero hex-bg">
    <!-- Animated particles -->
    <div class="particle" style="width:8px;height:8px;top:15%;left:10%;animation-delay:0s;animation-duration:7s;"></div>
    <div class="particle" style="width:5px;height:5px;top:30%;left:80%;animation-delay:1s;animation-duration:5s;"></div>
    <div class="particle" style="width:10px;height:10px;top:70%;left:15%;animation-delay:2s;animation-duration:8s;"></div>
    <div class="particle" style="width:6px;height:6px;top:60%;left:90%;animation-delay:0.5s;animation-duration:6s;"></div>
    <div class="particle" style="width:4px;height:4px;top:85%;left:50%;animation-delay:3s;animation-duration:9s;"></div>

    <div class="hero-container">
      <!-- Text side -->
      <div class="hero-text">
        <span class="hero-badge">
          <i class="fas fa-star"></i>
          حلول برمجية احترافية
        </span>

        <h1 class="hero-title">
          نصمم حلول برمجية<br>
          <span class="gold-gradient-text">احترافية ندعم نمو أعمالك</span>
        </h1>

        <p class="hero-desc">
          في دهب سوفتوير نقدم تطوير مواقع وتطبيقات ومتاجر إلكترونية وأنظمة مخصصة باحترافية عالية
          تساعدك على تحويل أفكارك إلى مشاريع ناجحة بمعايير السوق العالمية.
        </p>

        <div class="hero-ctas">
          <a href="https://wa.me/201234567890" target="_blank" class="btn-gold">
            <i class="fab fa-whatsapp"></i>
            تواصل عبر واتساب
          </a>
          <a href="#contact" class="btn-outline-gold">
            <i class="fas fa-file-invoice"></i>
            اطلب عرض سعر
          </a>
        </div>
      </div>

      <!-- Image side -->
      <div class="hero-image-wrap">
        <div class="hero-glow"></div>
        <img :src="heroImg" alt="منصة دهب سوفتوير" class="hero-image" />
      </div>
    </div>

    <!-- Bottom wave -->
    <div class="hero-wave">
      <svg viewBox="0 0 1440 80" preserveAspectRatio="none">
        <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#111111" opacity="0.6"/>
      </svg>
    </div>
  </section>
</template>

<script setup>
const heroImg = '/hero-devices.png'
</script>

<style scoped>
.hero {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  position: relative;
  overflow: hidden;
  padding-top: 100px;
}

.hero-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 3rem 2rem 5rem;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  align-items: center;
}

.hero-badge {
  background: rgba(201,162,39,0.1);
  border: 1px solid rgba(201,162,39,0.35);
  color: #f0c240;
  padding: 0.4rem 1.2rem;
  border-radius: 100px;
  font-size: 0.9rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.hero-title {
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 900;
  line-height: 1.35;
  color: #fff;
  margin-bottom: 1.25rem;
}

.hero-desc {
  color: #a0a0a0;
  font-size: 1rem;
  line-height: 1.8;
  margin-bottom: 2.5rem;
  max-width: 520px;
}

.hero-ctas {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.hero-image-wrap {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Ambient glow */
.hero-glow {
  position: absolute;
  width: 400px;
  height: 400px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(201,162,39,0.18) 0%, transparent 70%);
  pointer-events: none;
  animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
  0%,100% { transform: scale(1); opacity: 0.8; }
  50%      { transform: scale(1.1); opacity: 1; }
}

.hero-image {
  width: 100%;
  max-width: 520px;
  object-fit: contain;
  filter: drop-shadow(0 20px 40px rgba(201,162,39,0.25));
  position: relative;
  z-index: 1;
  animation: float-img 6s ease-in-out infinite;
}

@keyframes float-img {
  0%,100% { transform: translateY(0px); }
  50%      { transform: translateY(-12px); }
}

.hero-wave {
  position: absolute;
  bottom: 0;
  width: 100%;
  line-height: 0;
}

.hero-wave svg { width: 100%; height: 80px; display: block; }

@media (max-width: 900px) {
  .hero-container {
    grid-template-columns: 1fr;
    gap: 2rem;
    text-align: center;
    padding: 2rem 1.5rem 4rem;
  }
  .hero-title {
    font-size: 2.25rem;
  }
  .hero-desc {
    font-size: 0.95rem;
    margin: 0 auto 2rem;
  }
  .hero-ctas {
    justify-content: center;
    flex-direction: column;
    gap: 0.75rem;
  }
  .btn-gold, .btn-outline-gold {
    width: 100%;
    justify-content: center;
  }
  .hero-badge { margin: 0 auto 1.5rem; }
  .hero-image { max-width: 280px; }
}
</style>
