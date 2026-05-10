<template>
  <section id="top" class="hero-section hex-bg">
    <div class="hero-shell">
      <div class="hero-copy">
        <span class="hero-badge">
          <i class="fas fa-sparkles"></i>
          قيادة التحول الرقمي بذكاء وأناقة
        </span>

        <h1 class="hero-title">
          نصمم منتجات رقمية تبدو
          <span class="gold-gradient-text">فاخرة، سريعة، وسهلة الإدارة</span>
        </h1>

        <p class="hero-description">
          من مواقع الويب والمتاجر إلى لوحات التحكم والتطبيقات، نبني تجارب رقمية تجمع بين جمالية العرض،
          وضوح الرسالة، واعتمادية التنفيذ حتى يظهر مشروعك كما يجب أن يظهر.
        </p>

        <div class="hero-actions">
          <a href="#contact" class="btn-gold">
            <i class="fas fa-paper-plane"></i>
            اطلب عرض سعر
          </a>
          <a href="#portfolio" class="btn-outline-gold">
            <i class="fas fa-eye"></i>
            شاهد الأعمال
          </a>
        </div>

        <div class="hero-metrics">
          <article v-for="item in metrics" :key="item.label" class="hero-metric-card">
            <p>{{ item.label }}</p>
            <strong>{{ item.value }}</strong>
            <span>{{ item.note }}</span>
          </article>
        </div>
      </div>

      <div class="hero-visual">
        <div class="hero-device">
          <img :src="heroImg" alt="منصات دهب سوفتوير" class="hero-image" />
        </div>

        <div class="hero-floating hero-floating--top">
          <span>Luxury UX</span>
          <strong>واجهة تبيع الفكرة قبل الشرح</strong>
          <small>بداية قوية، تسلسل بصري مرتب، وهوية يصعب نسيانها.</small>
        </div>

        <div class="hero-floating hero-floating--bottom">
          <span>Scalable Delivery</span>
          <strong>منتج جاهز للنمو</strong>
          <small>قرارات تقنية مدروسة من أول شاشة إلى لوحة التحكم.</small>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const heroImg = '/hero-devices.png'

const metrics = [
  { label: 'نمط التنفيذ', value: 'Web + App', note: 'حلول متصلة بهوية واحدة.' },
  { label: 'الأولوية', value: 'Performance', note: 'سرعة، وضوح، واعتمادية.' },
  { label: 'اللغة البصرية', value: 'Premium UI', note: 'طابع راقٍ بعيد عن القوالب الجاهزة.' },
]
</script>

<style scoped>
.hero-section {
  position: relative;
  padding: 9.5rem 0 4.5rem;
  overflow: hidden;
}

.hero-shell {
  width: min(1180px, calc(100% - 2rem));
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1.05fr 0.95fr;
  gap: 1.75rem;
  align-items: center;
}


.hero-device,
.hero-floating,
.hero-metric-card {
  border: 1px solid rgba(255, 255, 255, 0.08);
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(14px);
  box-shadow: 0 22px 80px rgba(0, 0, 0, 0.24);
}

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.45rem 0.95rem;
  border-radius: 999px;
  background: rgba(240, 194, 64, 0.08);
  border: 1px solid rgba(240, 194, 64, 0.22);
  color: #f1d27d;
  font-size: 0.82rem;
  letter-spacing: 0.12em;
}

.hero-title {
  font-size: clamp(2.3rem, 5vw, 4.7rem);
  line-height: 1.15;
  font-weight: 900;
  color: #fff;
  margin: 1.4rem 0 1rem;
}

.hero-title span {
  display: block;
  padding: 13px 0;
}

.hero-description {
  color: #9ea7bc;
  line-height: 1.95;
  font-size: 1rem;
  max-width: 640px;
}

.hero-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.9rem;
  margin-top: 2rem;
}

.hero-metrics {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 0.9rem;
  margin-top: 2rem;
}

.hero-metric-card {
  border-radius: 26px;
  padding: 1.2rem;
}

.hero-metric-card p {
  margin: 0;
  color: #f0c240;
  font-weight: 700;
}

.hero-metric-card strong {
  display: block;
  color: #fff;
  margin: 0.85rem 0 0.45rem;
  font-size: 1.4rem;
}

.hero-metric-card span {
  color: #9ea7bc;
  line-height: 1.8;
  font-size: 0.9rem;
}

.hero-visual {
  position: relative;
  min-height: 540px;
}

.hero-device {
  position: absolute;
  inset: 0;
  border-radius: 34px;
  padding: 1.5rem;
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03)),
    radial-gradient(circle at top, rgba(240, 194, 64, 0.14), transparent 45%);
}

.hero-image {
  width: 100%;
  height: 100%;
  object-fit: contain;
  filter: drop-shadow(0 20px 45px rgba(0, 0, 0, 0.34));
}

.hero-floating {
  position: absolute;
  max-width: 245px;
  border-radius: 26px;
  padding: 1rem 1.1rem;
}

.hero-floating--top {
  top: 1rem;
  left: -1rem;
}

.hero-floating--bottom {
  right: -1rem;
  bottom: 0;
}

.hero-floating span {
  display: inline-flex;
  padding: 0.35rem 0.75rem;
  border-radius: 999px;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.08);
  color: #d8deea;
  font-size: 0.76rem;
}

.hero-floating strong {
  display: block;
  margin: 0.7rem 0 0.35rem;
  color: #fff;
}

.hero-floating small {
  color: #9ea7bc;
  line-height: 1.75;
}

@media (max-width: 1100px) {
  .hero-shell {
    grid-template-columns: 1fr;
  }

  .hero-visual {
    min-height: 440px;
  }
}

@media (max-width: 860px) {
  .hero-section {
    padding-top: 8.5rem;
  }

  .hero-metrics {
    grid-template-columns: 1fr;
  }

  .hero-visual {
    min-height: auto;
  }

  .hero-device {
    position: relative;
    min-height: 340px;
  }

  .hero-floating {
    position: static;
    max-width: none;
    margin-top: 1rem;
  }
}
</style>
