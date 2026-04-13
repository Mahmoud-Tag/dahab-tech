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

          <div class="modal-content" v-if="service">
            <div class="modal-header">
              <div class="modal-icon-box">
                <i :class="service.icon"></i>
              </div>
              <h3 class="modal-title">{{ service.title }}</h3>
            </div>

            <p class="modal-desc">{{ service.desc }}</p>

            <div v-if="service.features && service.features.length" class="modal-features">
              <h4 class="features-title">مميزات الخدمة</h4>
              <ul class="features-list">
                <li v-for="(feat, i) in service.features" :key="i" class="feature-item">
                  <i class="fas fa-check text-gold"></i>
                  <span>{{ feat }}</span>
                </li>
              </ul>
            </div>

            <div class="modal-actions">
              <a href="#contact" class="btn-primary" @click="close">
                اطلب الخدمة الآن
                <i class="fas fa-arrow-left"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { onMounted, onUnmounted, watch } from 'vue'

const props = defineProps({
  isOpen: Boolean,
  service: Object
})

const emit = defineEmits(['close'])

const close = () => {
  emit('close')
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
  background: rgba(0, 0, 0, 0.75);
  backdrop-filter: blur(8px);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
}

.modal-wrapper {
  position: relative;
  width: 100%;
  max-width: 600px;
}

.modal-container {
  position: relative;
  background: #0f0f0f;
  border: 1px solid rgba(201,162,39,0.3);
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.75), 0 0 30px rgba(201,162,39,0.1);
}

.modal-glow {
  position: absolute;
  top: -50px; left: 50%;
  transform: translateX(-50%);
  width: 200px; height: 100px;
  background: rgba(201,162,39,0.25);
  filter: blur(50px);
  z-index: 0;
  pointer-events: none;
}

.close-btn {
  position: absolute;
  top: 1.25rem; left: 1.25rem; /* left for RTL */
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  color: #ccc;
  width: 36px; height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.1rem;
  cursor: pointer;
  z-index: 10;
  transition: all 0.3s ease;
}

.close-btn:hover {
  background: rgba(201,162,39,0.2);
  color: #f0c240;
  border-color: rgba(201,162,39,0.5);
  transform: rotate(90deg);
}

.modal-content {
  position: relative;
  z-index: 1;
  padding: 2.5rem;
}

.modal-header {
  display: flex;
  align-items: center;
  gap: 1.2rem;
  margin-bottom: 1.5rem;
}

.modal-icon-box {
  width: 64px; height: 64px;
  border-radius: 16px;
  background: linear-gradient(135deg, rgba(201,162,39,0.2), rgba(201,162,39,0.05));
  border: 1.5px solid rgba(201,162,39,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.8rem;
  color: #f0c240;
  box-shadow: 0 0 20px rgba(201,162,39,0.15);
}

.modal-title {
  font-size: 1.5rem;
  font-weight: 800;
  color: #ffffff;
  margin: 0;
}

.modal-desc {
  color: #aaa;
  font-size: 1rem;
  line-height: 1.8;
  margin-bottom: 2rem;
}

.modal-features {
  background: rgba(255,255,255,0.02);
  border: 1px solid rgba(255,255,255,0.05);
  border-radius: 12px;
  padding: 1.5rem;
  margin-bottom: 2rem;
}

.features-title {
  color: #f0c240;
  font-size: 1.1rem;
  font-weight: 700;
  margin-bottom: 1rem;
}

.features-list {
  list-style: none;
  padding: 0; margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.8rem;
}

.feature-item {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  color: #ddd;
  font-size: 0.95rem;
  line-height: 1.5;
}

.text-gold {
  color: #f0c240;
  margin-top: 0.2rem;
  font-size: 0.85rem;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
}

.btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 0.6rem;
  background: linear-gradient(135deg, #f0c240, #c9a227);
  color: #000;
  font-weight: 700;
  padding: 0.8rem 1.8rem;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(201,162,39,0.3);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(201,162,39,0.4);
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
  .modal-wrapper {
    margin: 1rem;
    height: auto;
    max-height: calc(100vh - 2rem);
    display: flex;
    flex-direction: column;
  }
  .modal-container {
    display: flex;
    flex-direction: column;
    max-height: 100%;
    overflow-y: auto;
  }
  .modal-content {
    padding: 1.5rem 1rem;
    overflow-y: visible;
  }
  .modal-header {
    flex-direction: row;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
  }
  .modal-icon-box {
    width: 48px; height: 48px;
    font-size: 1.4rem;
  }
  .modal-title {
    font-size: 1.25rem;
  }
  .modal-desc {
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
  }
  .modal-features {
    padding: 1rem;
    margin-bottom: 1.5rem;
  }
  .features-title {
    font-size: 1rem;
  }
  .feature-item {
    font-size: 0.85rem;
  }
  .close-btn {
    top: 0.75rem;
    left: 0.75rem;
    width: 32px; height: 32px;
  }
  .btn-primary {
    width: 100%;
    justify-content: center;
  }
}
</style>
