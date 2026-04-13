<template>
  <section id="why-us" class="why-us">
    <div class="why-container">
      <h2 class="section-title">لماذا نختار دهب سوفتوير؟</h2>

      <div class="why-grid">
        <div class="why-card" v-for="item in reasons" :key="item.title">
          <div class="why-icon">
            <i :class="item.icon"></i>
          </div>
          <h3 class="why-title">{{ item.title }}</h3>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const reasons = [
  { icon: 'fas fa-headset',       title: 'دعم مستمر' },
  { icon: 'fas fa-robot',         title: 'دعم ذكي بالـ AI' },
  { icon: 'fas fa-tags',          title: 'أسعار تنافسية' },
  { icon: 'fas fa-tachometer-alt', title: 'سرعة في التنفيذ' },
  { icon: 'fas fa-award',         title: 'تصميم حصري' },
  { icon: 'fas fa-shield-alt',    title: 'جودة وأمانة عالية' },
]
</script>

<style scoped>
.why-us {
  padding: 6rem 0;
  background: #0d0d0d;
  position: relative;
  overflow: hidden;
}

.why-us::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 800px;
  height: 400px;
  background: radial-gradient(ellipse, rgba(201,162,39,0.07) 0%, transparent 70%);
  pointer-events: none;
}

.why-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
}

.why-grid {
  display: flex;
  justify-content: center;
  gap: 2rem;
  flex-wrap: wrap;
}

.why-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  text-align: center;
  padding: 2rem 1.5rem;
  background: #111;
  border: 1px solid rgba(201,162,39,0.2);
  border-radius: 16px;
  transition: all 0.3s;
  min-width: 160px;
  flex: 1;
  max-width: 200px;
  cursor: default;
}

.why-card:hover {
  border-color: #f0c240;
  transform: translateY(-6px);
  box-shadow: 0 12px 35px rgba(201,162,39,0.15);
}

.why-icon {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  background: linear-gradient(135deg, rgba(201,162,39,0.15), rgba(201,162,39,0.05));
  border: 2px solid rgba(201,162,39,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.7rem;
  color: #f0c240;
  transition: all 0.3s;
}

.why-card:hover .why-icon {
  background: rgba(201,162,39,0.2);
  border-color: #f0c240;
  box-shadow: 0 0 20px rgba(201,162,39,0.3);
}

.why-title {
  font-size: 0.95rem;
  font-weight: 700;
  color: #e5e5e5;
}

@media (max-width: 768px) {
  .why-card { min-width: 130px; max-width: none; }
}
</style>
