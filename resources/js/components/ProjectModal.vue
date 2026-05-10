<template>
  <Transition name="modal-bounce">
    <div v-if="isOpen" class="modal-overlay" @click.self="close">
      <div class="modal-wrapper">
        <div class="modal-container">
          <!-- background glow -->
          <div class="modal-glow"></div>

          <button class="close-btn" @click="close">
            <i class="fas fa-times"></i>
          </button>

          <div class="modal-content" v-if="project">
            <div class="modal-body-scroll">
              <!-- Image Header -->
              <div class="modal-img-top">
                <img :src="project.image" :alt="project.title" class="project-full-img" />
                <div class="img-overlay-details">
                  <span class="modal-cat-badge">
                    <i :class="project.catIcon"></i>
                    {{ project.category }}
                  </span>
                  <span class="modal-year">
                    <span class="lang-badges-container">
                      <span v-for="lang in (project.language || '').split(',').map(l => l.trim()).filter(Boolean)" :key="lang" class="lang-tag">
                        <i class="fas fa-code"></i>
                        {{ lang }}
                      </span>
                    </span>
                    <span class="mx-2">|</span>
                    {{ project.year }}
                  </span>
                </div>
              </div>

              <!-- Information -->
              <div class="modal-info-section">
                <h3 class="modal-title">{{ project.title }}</h3>

                <div class="modal-tags">
                  <span v-for="lang in (project.language || '').split(',').map(l => l.trim()).filter(Boolean)" :key="lang" class="tag-badge">
                    <i class="fas fa-code mr-1"></i>
                    {{ lang }}
                  </span>
                </div>

                <div class="modal-description">
                  <h4 class="info-label">عن المشروع</h4>
                  <p class="desc-text">{{ project.fullDesc || project.desc }}</p>
                </div>

                <div v-if="project.features && project.features.length" class="modal-features">
                  <h4 class="info-label">الميزات المدمجة</h4>
                  <ul class="features-list">
                    <li v-for="(feat, i) in (project.features || [])" :key="i" class="feature-item">
                      <i class="fas fa-check-circle text-gold"></i>
                      <span>{{ feat }}</span>
                    </li>
                  </ul>
                </div>

                <!-- Footer Stats & Link -->
                <div class="modal-footer-box">
                  <div class="stats-group" v-if="project.downloads !== undefined">
                    <div class="stat-item">
                      <i class="fas fa-download"></i>
                      <div class="stat-info">
                        <span class="stat-value">{{ project.downloads }}</span>
                        <span class="stat-label">تحميل</span>
                      </div>
                    </div>
                  </div>
                  <div class="action-group">
                    <a 
                      v-if="project.downloadUrl" 
                      :href="project.downloadUrl" 
                      target="_blank" 
                      class="btn-download"
                      @click="handleDownload"
                    >
                      <i class="fas fa-cloud-download-alt"></i>
                      {{ project.type === 'resource' ? 'تحميل المصدر' : 'تحميل المشروع' }}
                    </a>
                    <a href="#contact" class="btn-contact" @click="close">
                      اطلب مشروع مشابه
                      <i class="fas fa-arrow-left"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { onMounted, onUnmounted, watch } from 'vue'
import axios from 'axios'

const props = defineProps({
  isOpen: Boolean,
  project: Object
})

const emit = defineEmits(['close'])

const close = () => {
  emit('close')
}

const handleDownload = async () => {
  if (!props.project || !props.project.id) return

  try {
    // Increment on the backend
    await axios.post(`/api/projects/${props.project.id}/download`)
    
    // Increment locally for immediate visual update
    if (props.project.downloads !== undefined) {
      props.project.downloads++
    }
  } catch (error) {
    console.error('Error incrementing downloads:', error)
  }
}

// Close on escape key
const handleKeydown = (e) => {
  if (e.key === 'Escape' && props.isOpen) {
    close()
  }
}

watch(() => props.isOpen, (val) => {
  if (val) {
    document.body.style.overflow = 'hidden'
  } else {
    document.body.style.overflow = ''
  }
})

onMounted(() => {
  window.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown)
  document.body.style.overflow = ''
})
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0, 0, 0, 0.8);
  backdrop-filter: blur(12px);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1.5rem;
}

.modal-wrapper {
  position: relative;
  width: 100%;
  max-width: 800px;
  max-height: 90vh;
}

.modal-container {
  position: relative;
  background: #0d0d0d;
  border: 1px solid rgba(201,162,39,0.3);
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.9), 0 0 40px rgba(201,162,39,0.1);
  display: flex;
  flex-direction: column;
}

.modal-glow {
  position: absolute;
  top: -50px; left: 50%;
  transform: translateX(-50%);
  width: 300px; height: 150px;
  background: rgba(201,162,39,0.2);
  filter: blur(60px);
  z-index: 0;
  pointer-events: none;
}

.close-btn {
  position: absolute;
  top: 1.25rem; left: 1.25rem;
  background: rgba(0,0,0,0.5);
  border: 1px solid rgba(255,255,255,0.1);
  color: #fff;
  width: 40px; height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  cursor: pointer;
  z-index: 100;
  transition: all 0.3s ease;
}

.close-btn:hover {
  background: #f0c240;
  color: #000;
  border-color: #f0c240;
  transform: rotate(90deg);
}

.modal-content {
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.modal-body-scroll {
  overflow-y: auto;
  max-height: 90vh;
  scrollbar-width: thin;
  scrollbar-color: #f0c240 rgba(255,255,255,0.05);
}

.modal-body-scroll::-webkit-scrollbar {
  width: 6px;
}
.modal-body-scroll::-webkit-scrollbar-track {
  background: rgba(255,255,255,0.05);
}
.modal-body-scroll::-webkit-scrollbar-thumb {
  background-color: #f0c240;
  border-radius: 10px;
}

/* ── Image top ── */
.modal-img-top {
  position: relative;
  width: 100%;
  aspect-ratio: 21 / 9;
  overflow: hidden;
}

.project-full-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.img-overlay-details {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  padding: 1.5rem;
  background: linear-gradient(0deg, rgba(0,0,0,0.8), transparent);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-cat-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: rgba(201,162,39,0.9);
  color: #000;
  padding: 0.4rem 1rem;
  border-radius: 100px;
  font-weight: 700;
  font-size: 0.85rem;
}

.modal-year {
  color: #fff;
  font-weight: 600;
  text-shadow: 0 2px 4px rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.lang-badges-container {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.lang-tag {
  background: rgba(201, 162, 39, 0.15);
  border: 1px solid rgba(201, 162, 39, 0.4);
  color: #f0c240;
  padding: 0.2rem 0.6rem;
  border-radius: 6px;
  font-size: 0.75rem;
  display: flex;
  align-items: center;
  gap: 0.4rem;
}

.lang-tag i {
  font-size: 0.7rem;
  opacity: 0.8;
}

/* ── Info section ── */
.modal-info-section {
  padding: 2.5rem;
}

.modal-title {
  font-size: 1.8rem;
  font-weight: 800;
  color: #fff;
  margin-bottom: 1rem;
}

.modal-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.6rem;
  margin-bottom: 2rem;
}

.tag-badge {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  color: #aaa;
  padding: 0.25rem 0.8rem;
  border-radius: 6px;
  font-size: 0.8rem;
  font-weight: 600;
}

.info-label {
  color: #f0c240;
  font-size: 1.1rem;
  font-weight: 700;
  margin-bottom: 0.8rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.desc-text {
  color: #ccc;
  line-height: 1.8;
  font-size: 1rem;
  margin-bottom: 2rem;
}

.modal-features {
  background: rgba(255,255,255,0.02);
  border: 1px solid rgba(255,255,255,0.05);
  border-radius: 16px;
  padding: 1.5rem;
  margin-bottom: 2.5rem;
}

.features-list {
  list-style: none;
  padding: 0; margin: 0;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}

.feature-item {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  color: #ddd;
  font-size: 0.9rem;
}

.text-gold {
  color: #f0c240;
  margin-top: 0.1rem;
}

/* ── Footer ── */
.modal-footer-box {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 2rem;
  border-top: 1px solid rgba(255,255,255,0.05);
  gap: 2rem;
  flex-wrap: wrap;
}

.stats-group {
  display: flex;
  gap: 1.5rem;
}

.stat-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.stat-item i {
  font-size: 1.5rem;
  color: #f0c240;
  background: rgba(201,162,39,0.1);
  width: 45px; height: 45px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
}

.stat-info {
  display: flex;
  flex-direction: column;
}

.stat-value {
  color: #fff;
  font-size: 1.1rem;
  font-weight: 800;
}

.stat-label {
  color: #666;
  font-size: 0.75rem;
  font-weight: 600;
}

.action-group {
  display: flex;
  gap: 1rem;
}

.btn-download {
  display: inline-flex;
  align-items: center;
  gap: 0.6rem;
  background: #fff;
  color: #000;
  font-weight: 700;
  padding: 0.8rem 1.5rem;
  border-radius: 10px;
  text-decoration: none;
  transition: all 0.3s;
}

.btn-download:hover {
  background: #f0c240;
  transform: translateY(-2px);
}

.btn-contact {
  display: inline-flex;
  align-items: center;
  gap: 0.6rem;
  background: linear-gradient(135deg, rgba(201,162,39,0.2), rgba(201,162,39,0.05));
  border: 1px solid rgba(201,162,39,0.3);
  color: #f0c240;
  font-weight: 700;
  padding: 0.8rem 1.5rem;
  border-radius: 10px;
  text-decoration: none;
  transition: all 0.3s ease;
}

.btn-contact:hover {
  background: rgba(201,162,39,0.3);
  transform: translateY(-2px);
}

/* Animations */
.modal-bounce-enter-active {
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.modal-bounce-leave-active {
  transition: all 0.3s ease-in;
}
.modal-bounce-enter-from {
  opacity: 0;
  transform: scale(0.9) translateY(20px);
}
.modal-bounce-leave-to {
  opacity: 0;
  transform: scale(0.95) translateY(10px);
}

@media (max-width: 640px) {
  .modal-info-section { padding: 1.5rem; }
  .modal-title { font-size: 1.4rem; }
  .features-list { grid-template-columns: 1fr; }
  .modal-footer-box { flex-direction: column; align-items: flex-start; gap: 1.5rem; }
  .action-group { width: 100%; flex-direction: column; }
  .btn-download, .btn-contact { justify-content: center; }
  .modal-img-top { aspect-ratio: 16 / 9; }
}
</style>
