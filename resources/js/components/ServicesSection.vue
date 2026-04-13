<template>
  <section id="services" class="services-wrap">

    <!-- Top separator -->
    <div class="sep"></div>

    <div class="services-inner">

      <!-- Header -->
      <div class="section-header">
        <h2 class="section-title">خدماتنا</h2>
        <p class="section-subtitle">منظومة تقنية متكاملة تجمع بين البرمجة، الأمان، والذكاء الاصطناعي</p>
      </div>

      <!-- Category groups -->
      <div class="categories">
        <div
          v-for="(cat, i) in categories"
          :key="i"
          class="category-block"
        >
          <!-- Category label -->
          <div class="cat-label">
            <i :class="cat.icon"></i>
            <span>{{ cat.title }}</span>
          </div>

          <!-- Cards grid -->
          <div class="cards-grid" :class="'cols-' + cat.services.length">
            <ServiceCard
              v-for="svc in cat.services"
              :key="svc.title"
              :service="svc"
              @open-modal="openModal"
            />
          </div>
        </div>
      </div>

      <!-- Footer note -->
      <p class="footer-note">
        أقدم لك منظومة تقنية متكاملة تجمع بين البرمجة، الأمان، البنية التحتية،
        والتقنيات الذكية لضمان مشروع رقمي مستقر وآمن وقابل للنمو.
      </p>

    </div>

    <!-- Bottom separator -->
    <div class="sep"></div>

    <ServiceModal
      :is-open="isModalOpen"
      :service="selectedService"
      @close="closeModal"
    />
  </section>
</template>

<script setup>
import { ref } from 'vue'
import ServiceCard from './ServiceCard.vue'
import ServiceModal from './ServiceModal.vue'

const isModalOpen = ref(false)
const selectedService = ref(null)

const openModal = (svc) => {
  selectedService.value = svc
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
  setTimeout(() => { selectedService.value = null }, 300) // Clear after animation
}

const categories = [
  {
    title: 'تطوير الحلول الرقمية',
    icon: 'fas fa-laptop-code',
    services: [
      {
        icon: 'fas fa-globe', emoji: '💻', title: 'تطوير مواقع ويب احترافية', desc: 'تصميم وتطوير مواقع سريعة وآمنة ومتجاوبة مع جميع الأجهزة.',
        features: ['تصميم واجهات مستخدم جذابة وعصرية (UI/UX)', 'توافق تام مع مقاسات جميع الأجهزة المحمولة واللوحية', 'تحسين محركات البحث SEO لظهور موقعك في النتائج الأولى', 'لوحة تحكم سهلة لإدارة محتوى الموقع بالكامل']
      },
      {
        icon: 'fas fa-mobile-alt', emoji: '📱', title: 'تطوير تطبيقات موبايل', desc: 'بناء تطبيقات حديثة بأداء قوي وتجربة استخدام سلسة.',
        features: ['برمجة تطبيقات لأنظمة Android و iOS', 'واجهات مستخدم مخصصة لتجربة استخدام استثنائية', 'نشر التطبيقات على المتاجر الرسمية (Google Play, App Store)', 'ربط التطبيق بقواعد البيانات والخدمات السحابية']
      },
      {
        icon: 'fas fa-shopping-cart', emoji: '🛒', title: 'متاجر إلكترونية متكاملة', desc: 'حلول تجارة إلكترونية احترافية مع بوابات دفع ذكية.',
        features: ['إدارة متكاملة للمنتجات والطلبات والمخزون', 'ربط مع أشهر بوابات الدفع الإلكتروني المحلية والعالمية', 'نظام كوبونات وتخفيضات وإدارة حملات ترويجية', 'تقارير مفصلة للمبيعات وسلوك العملاء']
      },
      {
        icon: 'fas fa-cog', emoji: '⚙️', title: 'أنظمة إدارة مخصصة', desc: 'تصميم أنظمة CRM و ERP وأنظمة أعمال مخصصة.',
        features: ['تطوير أنظمة CRM لتحسين علاقات العملاء وإدارة المبيعات', 'واجهات ولوحات تحكم قابلة للتخصيص حسب متطلبات عملك', 'أتمتة المهام اليومية لتقليل الأخطاء البشرية وتسريع العمل', 'تكامل النظام مع الخدمات والأنظمة الأخرى (API Integrations)']
      },
    ]
  },
  {
    title: 'الأمن السيبراني والبنية التحتية',
    icon: 'fas fa-shield-alt',
    services: [
      {
        icon: 'fas fa-lock', emoji: '🔐', title: 'حلول حماية وأمن سيبراني', desc: 'تأمين التطبيقات والخوادم واختبار الثغرات الأمنية.',
        features: ['اختبار اختراق متقدم للويب والتطبيقات واكتشاف الثغرات', 'تطبيق بروتوكولات الحماية مثل SSL و WAF وغيرها', 'مراقبة مستمرة للأنظمة لاكتشاف أي نشاط مشبوه (SOC)', 'التدريب الاستشاري لفريق العمل لتفادي هجمات الهندسة الاجتماعية']
      },
      {
        icon: 'fas fa-network-wired', emoji: '🌐', title: 'إدارة الشبكات والبنية التحتية', desc: 'تصميم شبكات مستقرة وآمنة تضمن استمرارية الأعمال.',
        features: ['تصميم وبناء البنية التحتية للشبكات للشركات والمؤسسات', 'إدارة الخوادم السحابية والسيرفرات الخاصة', 'تنفيذ حلول النسخ الاحتياطي وتأمين البيانات لضمان عدم ضياعها', 'تحسين الأداء وتقليل فترات الانقطاع (Downtime)']
      },
    ]
  },
  {
    title: 'الحلول الذكية وتقنيات المستقبل',
    icon: 'fas fa-robot',
    services: [
      {
        icon: 'fas fa-robot', emoji: '🤖', title: 'أدوات ذكاء اصطناعي', desc: 'بناء حلول تعتمد على الذكاء الاصطناعي لتحليل البيانات.',
        features: ['تطوير روبوتات محادثة (Chatbots) لخدمة العملاء الآلية 24/7', 'دمج نماذج الذكاء الاصطناعي التوليدي و API في مشاريعك', 'أنظمة التوصية والمقترحات المخصصة لمتجرك الإلكتروني', 'أتمتة العمليات الصناعية أو الإدارية برمجياً']
      },
      {
        icon: 'fas fa-chart-bar', emoji: '📊', title: 'تحليل البيانات وتحسين الأداء', desc: 'استخراج رؤى استراتيجية تدعم اتخاذ القرار.',
        features: ['تجميع وتنظيف البيانات من مصادر متعددة', 'تصميم لوحات قياس (Dashboards) تفاعلية ومباشرة', 'استخدام خوارزميات التعلم الآلي للتنبؤ بالمستقبل', 'تحويل البيانات المعقدة إلى رؤى واضحة وقابلة للتنفيذ']
      },
      {
        icon: 'fas fa-headset', emoji: '🤖', title: 'دعم ذكي لخدمة العملاء', desc: 'يعتمد النظام على تقنيات ذكاء اصطناعي متقدمة لفهم استفسارات المستخدمين وتحليلها.',
        features: ['استخراج المعلومات الدقيقة من قاعدة بيانات المشروع', 'توفير دعم ذكي مدمج يعزز تجربة العميل', 'يقلل الاعتماد على الدعم التقليدي', 'ردود سريعة ودقيقة ومتاحة على مدار الساعة']
      },
    ]
  },
]
</script>

<style scoped>
/* ── wrapper ── */
.services-wrap {
  background: #111111;
  padding: 5rem 0;
  position: relative;
}

.sep {
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(201,162,39,0.4), transparent);
  margin: 0;
}

.services-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 4rem 2rem 2rem;
}

/* ── header ── */
.section-header { text-align: center; margin-bottom: 4rem; }

.section-title {
  font-size: 2.2rem;
  font-weight: 800;
  color: #f0c240;
  margin-bottom: 0.6rem;
  position: relative;
  display: inline-block;
}

.section-title::after {
  content: '';
  display: block;
  width: 60px;
  height: 3px;
  background: linear-gradient(90deg, #f0c240, #c9a227);
  margin: 0.6rem auto 0;
  border-radius: 2px;
}

.section-subtitle {
  color: #777;
  font-size: 1rem;
  margin-top: 0.75rem;
  line-height: 1.7;
}

/* ── categories ── */
.categories {
  display: flex;
  flex-direction: column;
  gap: 4rem;
}

/* ── category label ── */
.cat-label {
  display: inline-flex;
  align-items: center;
  gap: 0.65rem;
  background: rgba(201,162,39,0.08);
  border: 1px solid rgba(201,162,39,0.25);
  border-radius: 100px;
  padding: 0.45rem 1.25rem;
  color: #f0c240;
  font-weight: 700;
  font-size: 1rem;
  margin-bottom: 1.75rem;
}

.cat-label i { font-size: 0.95rem; }

/* ── cards grid ── */
.cards-grid {
  display: grid;
  gap: 1.5rem;
}

.cards-grid.cols-4 { grid-template-columns: repeat(4, 1fr); }
.cards-grid.cols-3 { grid-template-columns: repeat(3, 1fr); }
.cards-grid.cols-2 { grid-template-columns: repeat(2, 1fr); }
.cards-grid.cols-1 { grid-template-columns: 1fr; }

/* ── footer note ── */
.footer-note {
  text-align: center;
  color: #666;
  font-size: 0.95rem;
  line-height: 1.9;
  max-width: 640px;
  margin: 4rem auto 0;
  border-top: 1px solid rgba(201,162,39,0.1);
  padding-top: 2.5rem;
}

/* ── responsive ── */
@media (max-width: 1024px) {
  .cards-grid.cols-4 { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
  .cards-grid.cols-4,
  .cards-grid.cols-3,
  .cards-grid.cols-2 { grid-template-columns: 1fr; }
}
</style>
