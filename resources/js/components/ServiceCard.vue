<template>
  <article class="svc-card" @mouseenter="hovered = true" @mouseleave="hovered = false">

    <!-- Top accent bar (appears on hover) -->
    <div class="card-accent"></div>

    <!-- Icon box -->
    <div class="icon-box">
      <i :class="service.icon"></i>
    </div>

    <!-- Content -->
    <div class="card-body">
      <h4 class="card-title">{{ service.title }}</h4>
      <p class="card-desc">{{ service.desc }}</p>
    </div>

    <!-- Footer CTA -->
    <div class="card-footer">
      <span class="card-link" @click.prevent="$emit('open-modal', service)">
        اعرف أكثر
        <i class="fas fa-arrow-left link-arrow"></i>
      </span>
    </div>

  </article>
</template>

<script setup>
import { ref } from 'vue'
defineProps({ service: Object })
defineEmits(['open-modal'])
const hovered = ref(false)
</script>

<style scoped>
/* ── card shell ── */
.svc-card {
  position: relative;
  background: #0d0d0d;
  border: 1px solid rgba(201,162,39,0.18);
  border-radius: 18px;
  padding: 2rem 1.75rem 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 1.1rem;
  cursor: default;
  overflow: hidden;
  transition: border-color 0.35s, transform 0.35s, box-shadow 0.35s;
}

.svc-card:hover {
  border-color: rgba(201,162,39,0.6);
  transform: translateY(-7px);
  box-shadow: 0 16px 40px rgba(0,0,0,0.5), 0 0 25px rgba(201,162,39,0.15);
}

/* ── top accent bar ── */
.card-accent {
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, #f0c240, #c9a227, transparent);
  transform: scaleX(0);
  transform-origin: right;
  transition: transform 0.4s ease;
  border-radius: 18px 18px 0 0;
}

.svc-card:hover .card-accent {
  transform: scaleX(1);
}

/* ── icon box ── */
.icon-box {
  width: 62px;
  height: 62px;
  border-radius: 14px;
  background: linear-gradient(135deg, rgba(201,162,39,0.14), rgba(201,162,39,0.04));
  border: 1.5px solid rgba(201,162,39,0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  color: #f0c240;
  transition: all 0.35s;
  flex-shrink: 0;
}

.svc-card:hover .icon-box {
  background: linear-gradient(135deg, rgba(201,162,39,0.25), rgba(201,162,39,0.08));
  border-color: rgba(201,162,39,0.6);
  box-shadow: 0 0 18px rgba(201,162,39,0.25);
}

/* ── card body ── */
.card-body { flex: 1; }

.card-title {
  font-size: 1.05rem;
  font-weight: 800;
  color: #f0c240;
  margin-bottom: 0.6rem;
  line-height: 1.4;
}

.card-desc {
  color: #888;
  font-size: 0.88rem;
  line-height: 1.75;
}

/* ── footer link ── */
.card-footer {
  border-top: 1px solid rgba(201,162,39,0.1);
  padding-top: 0.9rem;
  margin-top: 0.4rem;
}

.card-link {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  color: rgba(201,162,39,0.6);
  font-size: 0.85rem;
  font-weight: 700;
  transition: color 0.3s, gap 0.3s;
  cursor: pointer;
}

.link-arrow {
  transition: transform 0.3s;
}

.svc-card:hover .card-link {
  color: #f0c240;
}

.svc-card:hover .link-arrow {
  transform: translateX(-4px);
}

@media (max-width: 640px) {
  .svc-card {
    padding: 1.5rem 1.25rem 1.25rem;
  }
  .icon-box {
    width: 54px;
    height: 54px;
    font-size: 1.3rem;
  }
  .card-title {
    font-size: 1rem;
  }
  .card-desc {
    font-size: 0.85rem;
  }
}

@media (hover: none) {
  /* Keep standard border and allow tap active state rather than hover */
  .svc-card:active {
    border-color: rgba(201,162,39,0.4);
    transform: translateY(-2px);
  }
}
</style>
