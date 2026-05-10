<template>
  <section id="portfolio" class="portfolio-section">
    <div class="portfolio-shell">
      <div class="portfolio-heading">
        <div>
          <span class="portfolio-kicker">أعمال مختارة</span>
          <h2 class="section-title" style="text-align:right;">نماذج تُظهر كيف يبدو المنتج عندما تُصمم كل طبقة بعناية.</h2>
        </div>
        <p class="portfolio-description">
          نعرض هنا مجموعة من المشاريع والموارد بتجارب أكثر وضوحاً، مع ترتيب بصري يساعد الزائر
          على فهم قيمة المشروع قبل الدخول في تفاصيله.
        </p>
      </div>

      <div class="filter-tabs">
        <button
          v-for="tab in tabs"
          :key="tab.key"
          type="button"
          :class="['filter-btn', { active: activeTab === tab.key }]"
          @click="activeTab = tab.key"
        >
          <i :class="tab.icon"></i>
          {{ tab.label }}
        </button>
      </div>

      <div v-if="loading" class="loading-grid">
        <div v-for="item in 4" :key="item" class="loading-card"></div>
      </div>

      <div v-else-if="filteredProjects.length === 0" class="empty-state">
        <i class="fas fa-folder-open"></i>
        <h3>لا توجد عناصر مطابقة حالياً</h3>
        <p>يمكنك تغيير الفلتر أو العودة لاحقاً بعد إضافة المشاريع من لوحة التحكم.</p>
      </div>

      <template v-else>
        <article v-if="featuredProject" class="featured-project">
          <div class="featured-project__media">
            <img :src="featuredProject.image" :alt="featuredProject.title" />
          </div>

          <div class="featured-project__copy">
            <div class="featured-project__chips">
              <span>{{ featuredProject.category }}</span>
              <span>{{ featuredProject.year || '2026' }}</span>
              <span>{{ typeLabel(featuredProject.type) }}</span>
            </div>

            <h3>{{ featuredProject.title }}</h3>
            <p>{{ featuredProject.fullDesc || featuredProject.desc }}</p>

            <div class="featured-project__tags">
              <span v-for="lang in (featuredProject.language || '').split(',').map(l => l.trim()).filter(Boolean)" :key="lang" class="lang-badge-sm">{{ lang }}</span>
            </div>

            <div class="featured-project__actions">
              <button type="button" class="btn-gold" @click="openProject(featuredProject)">
                <i class="fas fa-eye"></i>
                تفاصيل المشروع
              </button>
              <a href="#contact" class="btn-outline-gold">أريد مشروعاً مشابهاً</a>
            </div>
          </div>
        </article>

        <div class="project-grid">
          <article
            v-for="project in secondaryProjects"
            :key="project.id"
            class="project-card"
            @click="openProject(project)"
          >
            <div class="project-card__media">
              <img :src="project.image" :alt="project.title" />
            </div>

            <div class="project-card__copy">
              <div class="project-card__meta">
                <span>{{ project.category }}</span>
                <span>{{ typeLabel(project.type) }}</span>
              </div>
              <h3>{{ project.title }}</h3>
              <p>{{ project.desc }}</p>
              <div class="project-card__tags">
                <span v-for="lang in (project.language || '').split(',').map(l => l.trim()).filter(Boolean)" :key="lang" class="lang-badge-sm">{{ lang }}</span>
              </div>
            </div>
          </article>
        </div>
      </template>

      <div class="portfolio-cta">
        <p>إذا كانت لديك فكرة مشابهة، يمكننا تحويلها إلى تجربة رقمية متكاملة خاصة بعلامتك.</p>
        <a href="#contact" class="btn-gold">ابدأ مشروعك الآن</a>
      </div>

      <ProjectModal :is-open="isModalOpen" :project="selectedProject" @close="closeModal" />
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import ProjectModal from './ProjectModal.vue'

const activeTab = ref('all')
const isModalOpen = ref(false)
const selectedProject = ref(null)
const projects = ref([])
const loading = ref(true)

const fallbackImages = {
  web: '/portfolio-website.png',
  app: '/portfolio-app.png',
  system: '/portfolio-system.png',
  ecommerce: '/portfolio-ecommerce.png',
  ai: '/portfolio-system.png',
  resource: '/portfolio-system.png',
}

const normalizeArray = (value) => {
  if (Array.isArray(value)) return value
  if (typeof value === 'string' && value.trim()) {
    try {
      const parsed = JSON.parse(value)
      return Array.isArray(parsed) ? parsed : []
    } catch {
      return value.split(',').map((item) => item.trim()).filter(Boolean)
    }
  }
  return []
}

const fetchProjects = async () => {
  loading.value = true
  try {
    const { data } = await axios.get('/api/projects')
    projects.value = data.map((project) => ({
      ...project,
      image: project.image || fallbackImages[project.type] || '/portfolio-website.png',
      tags: normalizeArray(project.tags),
      features: normalizeArray(project.features),
    }))
  } catch (err) {
    console.error('Error fetching projects:', err)
  } finally {
    loading.value = false
  }
}

onMounted(fetchProjects)

const openProject = (project) => {
  selectedProject.value = project
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
  setTimeout(() => {
    selectedProject.value = null
  }, 250)
}

const tabs = [
  { key: 'all', label: 'الكل', icon: 'fas fa-grid-2' },
  { key: 'web', label: 'المواقع', icon: 'fas fa-globe' },
  { key: 'app', label: 'التطبيقات', icon: 'fas fa-mobile-screen-button' },
  { key: 'system', label: 'الأنظمة', icon: 'fas fa-chart-line' },
  { key: 'ecommerce', label: 'المتاجر', icon: 'fas fa-bag-shopping' },
  { key: 'resource', label: 'المصادر', icon: 'fas fa-box-open' },
]

const filteredProjects = computed(() =>
  activeTab.value === 'all'
    ? projects.value
    : projects.value.filter((project) => project.type === activeTab.value),
)

const featuredProject = computed(() => filteredProjects.value[0] || null)
const secondaryProjects = computed(() => filteredProjects.value.slice(1, 7))

const typeLabel = (type) => ({
  web: 'ويب',
  app: 'تطبيق',
  system: 'نظام',
  ecommerce: 'متجر',
  ai: 'AI',
  resource: 'مورد',
}[type] || 'منتج')
</script>

<style scoped>
.portfolio-section {
  padding: 5rem 0;
  position: relative;
}

.portfolio-shell {
  width: min(1180px, calc(100% - 2rem));
  margin: 0 auto;
}

.portfolio-heading {
  display: flex;
  justify-content: space-between;
  align-items: end;
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.portfolio-kicker {
  display: inline-flex;
  align-items: center;
  padding: 0.45rem 0.95rem;
  border-radius: 999px;
  background: rgba(240, 194, 64, 0.08);
  border: 1px solid rgba(240, 194, 64, 0.2);
  color: #f1d27d;
  font-size: 0.8rem;
  letter-spacing: 0.12em;
  margin-bottom: 0.2rem;
}

.portfolio-description {
  max-width: 420px;
  color: #9ea7bc;
  line-height: 1.9;
}

.filter-tabs,
.featured-project__chips,
.featured-project__tags,
.featured-project__actions,
.project-card__meta,
.project-card__tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.8rem;
  margin-top: 0.5rem;
}

.filter-tabs {
  margin-bottom: 1.5rem;
}

.filter-btn,
.featured-project__chips span,
.featured-project__tags span,
.project-card__meta span,
.project-card__tags span {
  border-radius: 999px;
  border: 1px solid rgba(255, 255, 255, 0.1);
  background: rgba(255, 255, 255, 0.04);
  color: #d9deea;
  padding: 0.7rem 1rem;
  font-weight: 700;
}

.filter-btn.active {
  background: rgba(240, 194, 64, 0.12);
  border-color: rgba(240, 194, 64, 0.24);
  color: #f0c240;
}

.lang-badge-sm {
  background: rgba(201, 162, 39, 0.1) !important;
  border-color: rgba(201, 162, 39, 0.3) !important;
  color: #f0c240 !important;
  font-size: 0.75rem !important;
  padding: 0.3rem 0.7rem !important;
}

.featured-project,
.project-card,
.loading-card,
.empty-state {
  border-radius: 30px;
  border: 1px solid rgba(255, 255, 255, 0.08);
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(14px);
  box-shadow: 0 22px 80px rgba(0, 0, 0, 0.28);
}

.loading-grid,
.project-grid {
  display: grid;
  gap: 1rem;
}

.loading-grid {
  grid-template-columns: repeat(4, 1fr);
}

.loading-card {
  height: 280px;
  animation: pulse 1.3s ease-in-out infinite;
}

.featured-project {
  display: grid;
  grid-template-columns: 1.05fr 0.95fr;
  overflow: hidden;
  margin-bottom: 1rem;
}

.featured-project__media {
  min-height: 440px;
}

.featured-project__media img,
.project-card__media img {
  width: 100%;
  height: 100%;
  display: block;
  object-fit: cover;
}

.featured-project__copy {
  padding: 1.6rem;
}

.featured-project__copy h3 {
  color: #fff;
  font-size: 2rem;
  margin: 1rem 0;
}

.featured-project__copy p,
.project-card__copy p,
.empty-state p,
.portfolio-cta p {
  color: #9ea7bc;
  line-height: 1.9;
}

.project-grid {
  grid-template-columns: repeat(3, 1fr);
}

.project-card {
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.22s ease, border-color 0.22s ease;
}

.project-card:hover {
  transform: translateY(-4px);
  border-color: rgba(240, 194, 64, 0.24);
}

.project-card__media {
  aspect-ratio: 16 / 10;
}

.project-card__copy {
  padding: 1.2rem;
}

.project-card__copy h3 {
  color: #fff;
  margin: 0.85rem 0 0.6rem;
  font-size: 1.15rem;
}

.empty-state {
  padding: 3rem 1.5rem;
  text-align: center;
}

.empty-state i {
  color: #f0c240;
  font-size: 2rem;
  margin-bottom: 1rem;
}

.empty-state h3 {
  color: #fff;
  margin: 0 0 0.75rem;
}

.portfolio-cta {
  margin-top: 2rem;
  text-align: center;
}

.portfolio-cta .btn-gold {
  margin-top: 1rem;
}

@keyframes pulse {
  0%, 100% { opacity: 0.55; }
  50% { opacity: 1; }
}

@media (max-width: 1100px) {
  .featured-project,
  .portfolio-heading {
    grid-template-columns: 1fr;
    display: grid;
  }

  .project-grid,
  .loading-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .project-grid,
  .loading-grid {
    grid-template-columns: 1fr;
  }

  .featured-project__media {
    min-height: 280px;
  }
}
</style>
