<template>
  <section id="portfolio" class="portfolio-wrap">
    
    <div class="sep"></div>

    <div class="portfolio-inner">
      <!-- Section Header -->
      <div class="section-header" data-aos="fade-up">
        <h2 class="section-title">مشاريعنا المنفذة</h2>
        <p class="section-subtitle">
          نفتخر باستعراض نخبة من أعمالنا التي تم تنفيذها بأعلى معايير الجودة <br> 
          والاحترافية لتلبي طموحات عملائنا.
        </p>
      </div>

      <!-- Filter Tabs -->
      <div class="filter-tabs" data-aos="fade-up" data-aos-delay="100">
        <button 
          v-for="tab in tabs" 
          :key="tab.key"
          @click="activeTab = tab.key"
          :class="['filter-btn', { active: activeTab === tab.key }]"
        >
          <i :class="tab.icon"></i>
          {{ tab.label }}
        </button>
      </div>

      <!-- Projects Grid -->
      <div v-if="loading" class="flex justify-center items-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-yellow-500"></div>
      </div>

      <div v-else-if="projects.length === 0" class="text-center py-20">
        <p class="text-gray-500 italic">لا توجد مشاريع مضافة حالياً.</p>
      </div>

      <div v-else>
        <transition-group 
          name="fade-grid" 
          tag="div" 
          class="projects-grid"
        >
          <div 
            v-for="project in filteredProjects" 
            :key="project.id"
            class="project-card"
            data-aos="zoom-in"
          >
            <!-- Project Image -->
            <div class="card-img-wrap">
              <img :src="project.image" :alt="project.title" class="card-img" />
              
              <!-- Hover Overlay -->
              <div class="card-overlay">
                <div class="overlay-content">
                  <span class="overlay-cat">{{ project.category }}</span>
                  <h3 class="overlay-title">{{ project.title }}</h3>
                  <p class="overlay-desc">{{ project.desc }}</p>
                  
                  <div class="card-actions">
                    <button @click="openProject(project)" class="btn-view">
                      <i class="fas fa-eye"></i>
                      تفاصيل المشروع
                    </button>
                  </div>

                  <div class="overlay-tags">
                    <span v-for="tag in project.tags" :key="tag" class="tag">{{ tag }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card Info -->
            <div class="card-info">
              <div class="card-meta">
                <span class="card-cat-badge">
                  <i :class="project.catIcon || 'fas fa-code'"></i>
                  {{ project.category }}
                </span>
                <span class="card-year">{{ project.year }}</span>
              </div>
              <h3 class="card-title">{{ project.title }}</h3>
              <div class="card-tags">
                <span v-for="tag in (project.tags || []).slice(0, 3)" :key="tag" class="tag-small">{{ tag }}</span>
              </div>
            </div>
          </div>
        </transition-group>
      </div>

      <!-- CTA or Contact -->
      <div class="portfolio-cta" data-aos="fade-up">
        <p class="text-gray-400 mb-6">هل لديك مشروع ترغب في تنفيذه؟ نحن هنا لنحول فكرتك إلى واقع.</p>
        <a href="#contact" class="btn-primary">ابدأ مشروعك الآن</a>
      </div>
    </div>

    <!-- Project Modal Detail -->
    <ProjectModal
      :is-open="isModalOpen"
      :project="selectedProject"
      @close="closeModal"
    />

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

const fetchProjects = async () => {
  loading.value = true
  try {
    const { data } = await axios.get('/api/projects')
    projects.value = data
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
  setTimeout(() => { selectedProject.value = null }, 300)
}

const tabs = [
  { key: 'all',      label: 'الكل',              icon: 'fas fa-th' },
  { key: 'web',      label: 'مواقع ويب',         icon: 'fas fa-globe' },
  { key: 'app',      label: 'تطبيقات',           icon: 'fas fa-mobile-alt' },
  { key: 'system',   label: 'أنظمة إدارة',       icon: 'fas fa-cogs' },
  { key: 'ecommerce',label: 'متاجر إلكترونية',   icon: 'fas fa-shopping-cart' },
  { key: 'ai',       label: 'ذكاء اصطناعي',      icon: 'fas fa-robot' },
  { key: 'resource', label: 'المصادر والأدوات',  icon: 'fas fa-box-open' },
]

const filteredProjects = computed(() =>
  activeTab.value === 'all'
    ? projects.value
    : projects.value.filter(p => p.type === activeTab.value)
)
</script>

<style scoped>
.portfolio-wrap {
  background: #0d0d0d;
  padding: 5rem 0;
}

.sep {
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(201,162,39,0.4), transparent);
}

.portfolio-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 4rem 2rem 2rem;
}

.section-header { text-align: center; margin-bottom: 3rem; }

.section-title {
  font-size: 2.2rem;
  font-weight: 800;
  color: #f0c240;
  margin-bottom: 0.6rem;
  display: inline-block;
  position: relative;
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

.filter-tabs {
  display: flex;
  justify-content: center;
  gap: 0.75rem;
  flex-wrap: wrap;
  margin-bottom: 3rem;
}

.filter-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1.25rem;
  border-radius: 100px;
  border: 1.5px solid rgba(201,162,39,0.25);
  background: transparent;
  color: #888;
  font-family: 'Cairo', sans-serif;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.filter-btn:hover {
  border-color: rgba(201,162,39,0.5);
  color: #f0c240;
}

.filter-btn.active {
  background: linear-gradient(135deg, rgba(201,162,39,0.2), rgba(201,162,39,0.05));
  border-color: #f0c240;
  color: #f0c240;
  box-shadow: 0 0 15px rgba(201,162,39,0.15);
}

.projects-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
  margin-bottom: 3.5rem;
}

.project-card {
  background: #111;
  border: 1px solid rgba(201,162,39,0.15);
  border-radius: 20px;
  overflow: hidden;
  transition: border-color 0.35s, transform 0.35s, box-shadow 0.35s;
}

.project-card:hover {
  border-color: rgba(201,162,39,0.5);
  transform: translateY(-6px);
  box-shadow: 0 16px 45px rgba(0,0,0,0.5), 0 0 25px rgba(201,162,39,0.1);
}

.card-img-wrap {
  position: relative;
  overflow: hidden;
  aspect-ratio: 16 / 9;
}

.card-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
  display: block;
}

.project-card:hover .card-img {
  transform: scale(1.06);
}

.card-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg,
    rgba(0,0,0,0.3) 0%,
    rgba(0,0,0,0.85) 100%
  );
  display: flex;
  align-items: flex-end;
  padding: 1.75rem;
  opacity: 0;
  transition: opacity 0.4s ease;
}

.project-card:hover .card-overlay {
  opacity: 1;
}

.overlay-content {
  transform: translateY(12px);
  transition: transform 0.4s ease;
}

.project-card:hover .overlay-content {
  transform: translateY(0);
}

.overlay-cat {
  display: inline-block;
  background: rgba(201,162,39,0.25);
  border: 1px solid rgba(201,162,39,0.5);
  color: #f0c240;
  font-size: 0.75rem;
  font-weight: 700;
  padding: 0.2rem 0.75rem;
  border-radius: 100px;
  margin-bottom: 0.6rem;
}

.overlay-title {
  font-size: 1.2rem;
  font-weight: 800;
  color: #fff;
  margin-bottom: 0.5rem;
}

.overlay-desc {
  font-size: 0.85rem;
  color: #ccc;
  line-height: 1.6;
  margin-bottom: 0.75rem;
}

.overlay-tags {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.tag {
  background: rgba(201,162,39,0.15);
  border: 1px solid rgba(201,162,39,0.3);
  color: #f0c240;
  font-size: 0.75rem;
  font-weight: 600;
  padding: 0.2rem 0.65rem;
  border-radius: 100px;
}

.card-actions {
  margin-bottom: 1rem;
}

.btn-view {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: #f0c240;
  color: #000;
  border: none;
  padding: 0.6rem 1.25rem;
  border-radius: 8px;
  font-weight: 700;
  font-family: 'Cairo', sans-serif;
  font-size: 0.85rem;
  cursor: pointer;
  transition: all 0.3s;
}

.btn-view:hover {
  background: #fff;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(240,194,64,0.3);
}

.card-info {
  padding: 1.4rem 1.6rem 1.6rem;
  display: flex;
  flex-direction: column;
  gap: 0.65rem;
}

.card-meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.card-cat-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  font-size: 0.78rem;
  color: rgba(201,162,39,0.75);
  font-weight: 600;
}

.card-year {
  font-size: 0.78rem;
  color: #555;
  font-weight: 600;
}

.card-title {
  font-size: 1.05rem;
  font-weight: 800;
  color: #e8e8e8;
  line-height: 1.4;
}

.card-tags {
  display: flex;
  gap: 0.4rem;
  flex-wrap: wrap;
}

.tag-small {
  background: rgba(201,162,39,0.07);
  border: 1px solid rgba(201,162,39,0.18);
  color: #888;
  font-size: 0.72rem;
  font-weight: 600;
  padding: 0.15rem 0.6rem;
  border-radius: 100px;
}

.portfolio-cta {
  text-align: center;
  padding-top: 1rem;
}

.fade-grid-enter-active,
.fade-grid-leave-active {
  transition: opacity 0.35s ease, transform 0.35s ease;
}
.fade-grid-enter-from,
.fade-grid-leave-to {
  opacity: 0;
  transform: scale(0.95) translateY(10px);
}

@media (max-width: 768px) {
  .projects-grid { grid-template-columns: 1fr; }
}

.btn-primary {
  display: inline-block;
  background: #f0c240;
  color: #000;
  font-weight: 700;
  padding: 1rem 2.5rem;
  border-radius: 50px;
  text-decoration: none;
  transition: all 0.3s ease;
  font-family: 'Cairo', sans-serif;
}

.btn-primary:hover {
  background: #fff;
  transform: translateY(-3px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.3);
}

.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
</style>
