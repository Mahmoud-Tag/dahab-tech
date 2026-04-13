<template>
  <section class="about gold-bg-glow" id="about">
    <div class="about-container">

      <!-- Person Image -->
      <div class="about-image-wrap">
        <div class="about-img-glow"></div>
        <img :src="aboutImg" alt="مدير دهب سوفتوير" class="about-image" />
        <div class="about-badge">
          <i class="fas fa-medal"></i>
          خبرة +5 سنوات
        </div>
      </div>

      <!-- Content -->
      <div class="about-content">
        <h2 class="section-title" style="text-align:right;">من نحن</h2>

        <p class="about-intro">
          نحن فريق خبراء تقنيين متخصصين في تطوير حلول رقمية مبتكرة تعتمد على أحدث التقنيات، ونسعى إلى تحويل الأفكار إلى مشاريع ناجحة ذات أثر حقيقي. نستخدم الذكاء الاصطناعي لتعزيز جودة وسرعة التطوير، مع إشراف تقني مباشر يضمن أعلى معايير الاحتراف والأمان. نقدم أنظمة وبرمجيات مخصصة وفق أعلى المعايير الاحترافية، بما يتوافق مع متطلبات ومعايير الأسواق المحلية والدولية.
        </p>

        <ul class="feature-list">
          <li class="feature-item" v-for="feat in features" :key="feat.text">
            <span class="icon-circle" style="width:48px;height:48px;font-size:1.1rem;">
              <i :class="feat.icon"></i>
            </span>
            <span class="feat-text">{{ feat.text }}</span>
          </li>
        </ul>
      </div>

    </div>
  </section>
</template>

<script setup>
const aboutImg = '/about-person.png'
const features = [
    { icon: 'fas fa-robot', text: 'تطوير حلول تعتمد على الذكاء الاصطناعي' },
  { icon: 'fas fa-code', text: 'خبرة في تطوير الويب والتطبيقات' },
  { icon: 'fas fa-lock', text: 'خبرة في الأمن السيبراني وحماية الأنظمة' },
  { icon: 'fas fa-shield-alt', text: 'قوة، ثقة وقابل للتطوير' },
  { icon: 'fas fa-headset', text: 'دعم فني مستمر' },
]
</script>

<style scoped>
.about {
  padding: 6rem 0;
  position: relative;
  overflow: hidden;
}

.about-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
  display: grid;
  grid-template-columns: 1fr 1.2fr;
  gap: 5rem;
  align-items: center;
}

.about-image-wrap {
  position: relative;
  display: flex;
  justify-content: center;
}

.about-img-glow {
  position: absolute;
  inset: -20px;
  background: radial-gradient(ellipse at center, rgba(201,162,39,0.15) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}

.about-image {
  width: 100%;
  max-width: 420px;
  object-fit: cover;
  border-radius: 20px;
  border: 2px solid rgba(201,162,39,0.25);
  box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 30px rgba(201,162,39,0.1);
  position: relative;
  z-index: 1;
}

.about-badge {
  position: absolute;
  bottom: 20px;
  left: 20px;
  background: linear-gradient(135deg, #f0c240, #c9a227);
  color: #000;
  font-weight: 800;
  font-size: 0.85rem;
  padding: 0.5rem 1rem;
  border-radius: 100px;
  display: flex;
  align-items: center;
  gap: 0.4rem;
  z-index: 2;
  box-shadow: 0 4px 15px rgba(0,0,0,0.4);
}

.about-intro {
  color: #a0a0a0;
  line-height: 1.9;
  margin-bottom: 2rem;
  font-size: 0.97rem;
}

.feature-list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 0;
}

.feat-text {
  font-size: 1rem;
  font-weight: 600;
  color: #e0e0e0;
}

@media (max-width: 900px) {
  .about-container {
    grid-template-columns: 1fr;
    gap: 2.5rem;
    padding: 0 1.5rem;
  }
  .about-image { max-width: 280px; }
  .section-title {
    text-align: center !important;
  }
  .section-title::after {
    margin: 0.6rem auto 0 !important;
  }
  .about-intro {
    text-align: center;
    font-size: 0.9rem;
  }
}
</style>
