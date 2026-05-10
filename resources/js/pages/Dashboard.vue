<template>
  <div class="min-h-screen bg-[#050816] font-['Cairo'] text-slate-100">
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
      <div class="absolute left-1/2 top-[-14rem] h-[28rem] w-[28rem] -translate-x-1/2 rounded-full bg-amber-400/10 blur-3xl"></div>
      <div class="absolute right-[-6rem] top-1/3 h-64 w-64 rounded-full bg-amber-400/8 blur-3xl"></div>
      <div class="absolute bottom-[-7rem] left-[-4rem] h-72 w-72 rounded-full bg-amber-400/6 blur-3xl"></div>
    </div>

    <div class="relative mx-auto flex min-h-screen max-w-[1500px]">
      <aside class="hidden w-80 shrink-0 border-l border-white/10 bg-slate-950/80 px-6 py-8 backdrop-blur-xl lg:flex lg:flex-col">
        <div class="rounded-[28px] border border-white/10 bg-white/[0.05] p-5 shadow-[0_24px_80px_rgba(2,6,23,0.42)]">
          <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-400/15 text-2xl text-amber-200 ring-1 ring-amber-300/20">
              <i class="fas fa-gem"></i>
            </div>
            <div>
              <p class="text-xs uppercase tracking-[0.28em] text-amber-200/70">Dahab Admin</p>
              <h1 class="mt-1 text-2xl font-black text-white">لوحة التحكم</h1>
            </div>
          </div>
          <p class="mt-4 text-sm leading-7 text-slate-400">واجهة أوضح لإدارة المشاريع والموارد ورسائل العملاء من مكان واحد.</p>
        </div>

        <nav class="mt-8 space-y-3">
          <button v-for="tab in tabs" :key="tab.key" type="button" class="w-full rounded-[24px] border px-4 py-4 text-right transition" :class="activeTab === tab.key ? tab.active : 'border-white/10 bg-white/[0.03] hover:border-white/15 hover:bg-white/[0.06]'" @click="selectTab(tab.key)">
            <div class="flex items-start gap-4">
              <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl ring-1" :class="tab.iconClass">
                <i :class="tab.icon"></i>
              </div>
              <div class="min-w-0 flex-1">
                <div class="flex items-center justify-between gap-3">
                  <p class="truncate text-base font-bold text-white">{{ tab.label }}</p>
                  <span class="rounded-full border px-2.5 py-1 text-xs font-semibold" :class="tab.badgeClass">{{ formatNumber(tab.count) }}</span>
                </div>
                <p class="mt-1 text-sm text-slate-400">{{ tab.desc }}</p>
              </div>
            </div>
          </button>
        </nav>

        <div class="mt-8 rounded-[26px] border border-white/10 bg-white/[0.04] p-5">
          <p class="text-xs uppercase tracking-[0.24em] text-amber-200/70">ملخص سريع</p>
          <div class="mt-4 space-y-3 text-sm text-slate-400">
            <div class="flex items-center justify-between gap-4"><span class="text-slate-500">آخر تحديث</span><span class="font-semibold text-white">{{ lastUpdatedLabel }}</span></div>
            <div class="flex items-center justify-between gap-4"><span class="text-slate-500">إجمالي العناصر</span><span class="font-semibold text-white">{{ formatNumber(stats.total) }}</span></div>
            <div class="flex items-center justify-between gap-4"><span class="text-slate-500">إجمالي التحميلات</span><span class="font-semibold text-white">{{ formatNumber(stats.downloads) }}</span></div>
          </div>
          <button type="button" class="mt-5 flex w-full items-center justify-center gap-3 rounded-2xl border border-white/10 bg-white/[0.05] px-4 py-3 text-sm font-semibold text-white transition hover:border-white/15 hover:bg-white/[0.08]" :disabled="refreshing" @click="refreshData">
            <i class="fas" :class="refreshing ? 'fa-spinner fa-spin' : 'fa-rotate-right'"></i>
            تحديث البيانات
          </button>
        </div>

        <button type="button" class="mt-auto flex items-center justify-center gap-3 rounded-[22px] border border-rose-400/20 bg-rose-500/10 px-4 py-4 font-semibold text-rose-100 transition hover:border-rose-300/30 hover:bg-rose-500/15 disabled:opacity-60" :disabled="loggingOut" @click="logout">
          <i class="fas" :class="loggingOut ? 'fa-spinner fa-spin' : 'fa-right-from-bracket'"></i>
          {{ loggingOut ? 'جاري تسجيل الخروج...' : 'تسجيل الخروج' }}
        </button>
      </aside>

      <main class="flex-1 px-4 py-4 sm:px-6 sm:py-6 lg:px-8 lg:py-8">
        <div class="mb-4 flex items-center justify-between lg:hidden">
          <div>
            <p class="text-xs uppercase tracking-[0.22em] text-amber-200/70">Dahab Admin</p>
            <h1 class="mt-1 text-2xl font-black text-white">لوحة التحكم</h1>
          </div>
          <div class="flex items-center gap-3">
            <button type="button" class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.05] text-slate-100" :disabled="refreshing" @click="refreshData">
              <i class="fas" :class="refreshing ? 'fa-spinner fa-spin' : 'fa-rotate-right'"></i>
            </button>
            <button type="button" class="flex h-11 w-11 items-center justify-center rounded-2xl border border-rose-400/20 bg-rose-500/10 text-rose-100" :disabled="loggingOut" @click="logout">
              <i class="fas" :class="loggingOut ? 'fa-spinner fa-spin' : 'fa-right-from-bracket'"></i>
            </button>
          </div>
        </div>

        <section class="overflow-hidden rounded-[32px] border border-white/10 bg-slate-950/70 p-6 shadow-[0_32px_100px_rgba(2,6,23,0.42)] backdrop-blur-xl sm:p-8">
          <div class="grid gap-6 xl:grid-cols-[1.45fr_0.9fr]">
            <div>
              <p class="text-xs uppercase tracking-[0.34em] text-amber-400">Command Center</p>
              <h2 class="mt-4 text-3xl font-black leading-tight text-white sm:text-4xl">إدارة أسرع، وتنقل أوضح، ومتابعة أدق للمحتوى.</h2>
              <p class="mt-4 max-w-3xl text-sm leading-8 text-slate-400 sm:text-base">ابدأ من القسم الذي يحتاج اهتمامك الآن، راقب الأرقام الأساسية، وأنجز التعديلات دون ازدحام في الواجهة.</p>
              <div class="mt-6 flex flex-wrap gap-3">
                <span class="rounded-full border border-white/10 bg-white/[0.04] px-4 py-2 text-sm text-slate-200">القسم النشط: <strong class="font-bold text-white">{{ activeTabMeta.label }}</strong></span>
                <span class="rounded-full border border-emerald-400/20 bg-emerald-400/10 px-4 py-2 text-sm text-emerald-100">{{ resultsLabel }}</span>
              </div>
              <div class="mt-6 flex flex-wrap gap-3">
                <button v-if="canCreate" type="button" class="inline-flex items-center gap-3 rounded-2xl bg-amber-400 px-5 py-3 font-black text-slate-950 shadow-[0_18px_40px_rgba(251,191,36,0.28)] transition hover:-translate-y-0.5" @click="openModal()">
                  <i class="fas fa-plus"></i>
                  {{ primaryActionLabel }}
                </button>
                <button type="button" class="inline-flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.04] px-5 py-3 font-semibold text-white transition hover:border-white/15 hover:bg-white/[0.08]" @click="selectTab('messages')">
                  <i class="fas fa-inbox"></i>
                  مراجعة الرسائل
                </button>
              </div>
            </div>
            <div class="grid gap-4">
              <div class="rounded-[26px] border border-white/10 bg-white/[0.05] p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-amber-200/70">Spotlight</p>
                <template v-if="featuredItem">
                  <div class="mt-4 flex flex-wrap gap-2">
                    <span class="rounded-full border border-white/10 bg-white/[0.04] px-3 py-1 text-xs text-slate-300">{{ featuredItem.category || 'غير مصنف' }}</span>
                    <span v-for="lang in (featuredItem.language || '').split(',').map(l => l.trim()).filter(Boolean)" :key="lang" class="rounded-full border border-amber-300/15 bg-amber-400/5 px-3 py-1 text-xs text-amber-200/80">{{ lang }}</span>
                    <span class="rounded-full border border-amber-300/20 bg-amber-400/10 px-3 py-1 text-xs text-amber-100">{{ typeLabel(featuredItem.type) }}</span>
                  </div>
                  <h3 class="mt-4 text-2xl font-black text-white">{{ featuredItem.title }}</h3>
                  <p class="mt-4 text-sm leading-8 text-slate-400">{{ itemSummary(featuredItem) }}</p>
                </template>
                <div v-else class="mt-4 rounded-2xl border border-dashed border-white/10 bg-white/[0.03] p-5 text-sm text-slate-500">لا يوجد عنصر لعرضه حالياً.</div>
              </div>
              <div class="rounded-[26px] border border-white/10 bg-white/[0.05] p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-amber-200/70">آخر رسالة</p>
                <template v-if="latestMessage">
                  <p class="mt-4 text-lg font-bold text-white">{{ latestMessage.name }}</p>
                  <p class="mt-1 text-sm text-slate-500">{{ latestMessage.email }}</p>
                  <p class="mt-4 text-sm leading-8 text-slate-400">{{ latestMessage.message }}</p>
                </template>
                <div v-else class="mt-4 rounded-2xl border border-dashed border-white/10 bg-white/[0.03] p-5 text-sm text-slate-500">صندوق الوارد فارغ حالياً.</div>
              </div>
            </div>
          </div>
        </section>

        <div v-if="errorMessage" class="mt-6 flex items-start justify-between gap-4 rounded-[22px] border border-rose-400/25 bg-rose-500/10 px-4 py-4 text-sm text-rose-50">
          <div class="flex items-start gap-3"><i class="fas fa-triangle-exclamation mt-1"></i><p class="leading-7">{{ errorMessage }}</p></div>
          <button type="button" class="text-rose-100/80 transition hover:text-white" @click="errorMessage = ''"><i class="fas fa-xmark"></i></button>
        </div>

        <section class="mt-6 grid gap-4 md:grid-cols-2 2xl:grid-cols-4">
          <article v-for="card in summaryCards" :key="card.key" class="rounded-[26px] border p-5 shadow-[0_22px_70px_rgba(2,6,23,0.28)]" :class="card.shell">
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-sm text-slate-400">{{ card.label }}</p>
                <p class="mt-3 text-3xl font-black text-white">{{ formatNumber(card.value) }}</p>
                <p class="mt-2 text-sm leading-6 text-slate-400">{{ card.hint }}</p>
              </div>
              <div class="flex h-14 w-14 items-center justify-center rounded-2xl ring-1" :class="card.iconClass"><i :class="card.icon"></i></div>
            </div>
          </article>
        </section>

        <section class="mt-6 rounded-[32px] border border-white/10 bg-slate-950/80 shadow-[0_28px_90px_rgba(2,6,23,0.35)] backdrop-blur-xl">
          <div class="border-b border-white/10 p-6">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
              <div>
                <p class="text-xs uppercase tracking-[0.24em] text-amber-200/70">Workspace</p>
                <h3 class="mt-2 text-2xl font-black text-white">{{ activeTabMeta.label }}</h3>
                <p class="mt-2 text-sm leading-7 text-slate-400">{{ activeTabMeta.desc }}</p>
              </div>
              <div class="flex flex-col gap-3 lg:flex-row lg:items-center">
                <div class="flex flex-wrap gap-2">
                  <button v-for="tab in tabs" :key="`pill-${tab.key}`" type="button" class="rounded-full border px-4 py-2.5 text-sm font-semibold transition" :class="activeTab === tab.key ? tab.pill : 'border-white/10 bg-white/[0.04] text-slate-300 hover:border-white/15 hover:bg-white/[0.08]'" @click="selectTab(tab.key)">
                    <span class="inline-flex items-center gap-2"><i :class="tab.icon"></i>{{ tab.label }}</span>
                  </button>
                </div>
                <div class="relative min-w-[min(100%,21rem)] flex-1">
                  <i class="fas fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                  <input v-model="searchQuery" type="search" :placeholder="searchPlaceholder" class="w-full rounded-2xl border border-white/10 bg-white/[0.04] py-3 pr-4 pl-11 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-amber-300/40 focus:bg-white/[0.06]">
                </div>
              </div>
            </div>
          </div>

          <div v-if="loading" class="grid gap-4 p-6 md:grid-cols-2 xl:grid-cols-3">
            <div v-for="index in 6" :key="index" class="h-64 animate-pulse rounded-[24px] border border-white/10 bg-white/[0.04]"></div>
          </div>

          <div v-else-if="activeTab === 'messages'" class="p-6">
            <div v-if="filteredMessages.length === 0" class="rounded-[26px] border border-dashed border-white/10 bg-white/[0.03] px-6 py-14 text-center">
              <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white/[0.05] text-2xl text-slate-400"><i class="fas fa-inbox"></i></div>
              <h4 class="mt-5 text-xl font-black text-white">لا توجد رسائل مطابقة</h4>
              <p class="mt-3 text-sm leading-7 text-slate-500">غيّر كلمات البحث أو عد إلى كل الرسائل لمتابعة الوارد بالكامل.</p>
            </div>
            <div v-else class="grid gap-4 lg:grid-cols-2">
              <article v-for="message in filteredMessages" :key="message.id" class="flex h-full flex-col rounded-[26px] border border-white/10 bg-white/[0.03] p-5 transition hover:border-amber-300/30 hover:bg-white/[0.05]">
                <div class="flex items-start justify-between gap-4">
                  <div class="flex items-start gap-3">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-400/15 text-base font-black text-amber-200 ring-1 ring-amber-300/20">{{ initial(message.name) }}</div>
                    <div class="min-w-0">
                      <h4 class="truncate text-lg font-bold text-white">{{ message.name }}</h4>
                      <p class="mt-1 truncate text-sm text-slate-400">{{ message.email }}</p>
                    </div>
                  </div>
                  <button type="button" class="flex h-10 w-10 items-center justify-center rounded-2xl border border-rose-400/15 bg-rose-500/10 text-rose-100 transition hover:border-rose-300/30 hover:bg-rose-500/15 disabled:opacity-60" :disabled="deletingKey === `message-${message.id}`" @click="deleteMessage(message.id)">
                    <i class="fas" :class="deletingKey === `message-${message.id}` ? 'fa-spinner fa-spin' : 'fa-trash'"></i>
                  </button>
                </div>
                <p class="mt-5 flex-1 text-sm leading-8 text-slate-400">{{ message.message }}</p>
                <div class="mt-5 flex items-center justify-between gap-4 border-t border-white/10 pt-4 text-xs text-slate-500">
                  <span>{{ formatDate(message.created_at) }}</span>
                  <button type="button" class="font-semibold text-amber-200 transition hover:text-amber-100" @click="copyEmail(message.email)">نسخ البريد</button>
                </div>
              </article>
            </div>
          </div>

          <div v-else class="p-6">
            <div v-if="filteredItems.length === 0" class="rounded-[26px] border border-dashed border-white/10 bg-white/[0.03] px-6 py-14 text-center">
              <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white/[0.05] text-2xl text-slate-400"><i class="fas fa-layer-group"></i></div>
              <h4 class="mt-5 text-xl font-black text-white">لا توجد عناصر مطابقة</h4>
              <p class="mt-3 text-sm leading-7 text-slate-500">يمكنك إنشاء عنصر جديد أو تعديل البحث للوصول إلى ما تريده بسرعة.</p>
            </div>
            <div v-else class="grid gap-5 md:grid-cols-2 2xl:grid-cols-3">
              <article v-for="item in filteredItems" :key="item.id" class="flex h-full flex-col overflow-hidden rounded-[26px] border border-white/10 bg-white/[0.03] transition hover:border-amber-300/30 hover:bg-white/[0.05]">
                <div class="relative h-48 overflow-hidden border-b border-white/10 bg-[radial-gradient(circle_at_top,rgba(251,191,36,0.22),rgba(14,165,233,0.08),transparent_62%),linear-gradient(135deg,#0f172a,#111827,#020617)]">
                  <img v-if="item.image" :src="item.image" :alt="item.title" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                  <div v-else class="flex h-full items-center justify-center text-center">
                    <div>
                      <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-xl text-amber-200 ring-1 ring-white/10"><i :class="item.type === 'resource' ? 'fas fa-box-open' : 'fas fa-diagram-project'"></i></div>
                      <p class="mt-4 text-sm font-semibold text-slate-300">{{ typeLabel(item.type) }}</p>
                    </div>
                  </div>
                  <div class="absolute right-4 top-4 flex flex-wrap gap-2">
                    <span class="rounded-full border border-white/10 bg-slate-950/65 px-3 py-1 text-xs font-semibold text-white backdrop-blur">{{ item.category || 'غير مصنف' }}</span>
                    <span class="rounded-full border border-amber-300/20 bg-amber-400/10 px-3 py-1 text-xs font-semibold text-amber-100 backdrop-blur">{{ typeLabel(item.type) }}</span>
                  </div>
                </div>
                <div class="flex flex-1 flex-col p-5">
                  <h4 class="text-xl font-black text-white">{{ item.title }}</h4>
                  <p class="mt-2 text-sm text-slate-400">{{ item.year || 'بدون سنة' }}</p>
                  <p class="mt-2 text-md text-white bg-amber-200/30 rounded-full px-2 py-1 w-fit">{{ formatNumber(item.downloads || 0) }} تحميل</p>
                  <p class="mt-4 flex-1 text-sm leading-8 text-slate-400">{{ itemSummary(item) }}</p>
                  <div class="mt-5 flex flex-wrap gap-2">
                    <span v-for="lang in (item.language || '').split(',').map(l => l.trim()).filter(Boolean)" :key="`${item.id}-${lang}`" class="rounded-full border border-amber-400/15 bg-amber-400/5 px-3 py-1 text-xs font-medium text-amber-200/90">{{ lang }}</span>
                  </div>
                  <div class="mt-5 flex items-center justify-between gap-3 border-t border-white/10 pt-4">
                    <a v-if="item.downloadUrl && item.downloadUrl !== '#'" :href="item.downloadUrl" target="_blank" rel="noreferrer" class="text-sm font-semibold text-amber-200 transition hover:text-amber-100">{{ item.type === 'resource' ? 'فتح الرابط' : 'معاينة الرابط' }}</a>
                    <span v-else class="text-sm text-slate-500">لا يوجد رابط متاح</span>
                    <div class="flex items-center gap-2">
                      <button type="button" class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.04] text-slate-100 transition hover:border-white/15 hover:bg-white/[0.08]" @click="openModal(item)"><i class="fas fa-pen-to-square"></i></button>
                      <button type="button" class="flex h-11 w-11 items-center justify-center rounded-2xl border border-rose-400/15 bg-rose-500/10 text-rose-100 transition hover:border-rose-300/30 hover:bg-rose-500/15 disabled:opacity-60" :disabled="deletingKey === `project-${item.id}`" @click="deleteProject(item.id)"><i class="fas" :class="deletingKey === `project-${item.id}` ? 'fa-spinner fa-spin' : 'fa-trash'"></i></button>
                    </div>
                  </div>
                </div>
              </article>
            </div>
          </div>
        </section>
      </main>
    </div>

    <ProjectFormModal v-if="showModal" :project="selectedProject" :default-type="activeTab === 'resources' ? 'resource' : 'web'" @close="closeModal" @saved="handleSaved" />
  </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import ProjectFormModal from '../components/ProjectFormModal.vue'

const router = useRouter()
const projects = ref([])
const messages = ref([])
const showModal = ref(false)
const selectedProject = ref(null)
const activeTab = ref('projects')
const searchQuery = ref('')
const errorMessage = ref('')
const lastUpdated = ref('')
const loading = ref(true)
const refreshing = ref(false)
const loggingOut = ref(false)
const deletingKey = ref('')

const getToken = () => localStorage.getItem('admin_token')
const goToLogin = () => { localStorage.removeItem('admin_token'); router.push('/admin/login') }
const normalize = (value) => String(value ?? '').toLowerCase()
const formatNumber = (value) => new Intl.NumberFormat('ar-EG').format(Number(value || 0))
const formatDate = (value) => value ? new Intl.DateTimeFormat('ar-EG', { dateStyle: 'medium', timeStyle: 'short' }).format(new Date(value)) : 'غير متوفر'
const initial = (name) => String(name ?? '؟').trim().charAt(0).toUpperCase() || '؟'
const itemSummary = (item) => item?.desc || item?.fullDesc || 'لا يوجد وصف متاح لهذا العنصر حتى الآن.'
const typeLabel = (type) => ({ web: 'موقع ويب', app: 'تطبيق', system: 'نظام', ecommerce: 'متجر', ai: 'ذكاء اصطناعي', resource: 'مورد' }[type] || 'عنصر')

const stats = computed(() => ({
  projects: projects.value.filter((item) => item.type !== 'resource').length,
  resources: projects.value.filter((item) => item.type === 'resource').length,
  messages: messages.value.length,
  downloads: projects.value.reduce((total, item) => total + Number(item.downloads || 0), 0),
  total: projects.value.length + messages.value.length,
}))

const tabs = computed(() => [
  { key: 'projects', label: 'المشاريع', desc: 'الأعمال والخدمات المنشورة.', icon: 'fas fa-rocket', count: stats.value.projects, active: 'border-cyan-300/25 bg-cyan-400/10', pill: 'border-cyan-300/20 bg-cyan-400/10 text-cyan-100', badgeClass: 'border-cyan-300/20 bg-cyan-400/10 text-cyan-100', iconClass: 'bg-cyan-400/12 text-cyan-100 ring-cyan-300/20' },
  { key: 'resources', label: 'المصادر', desc: 'الأدوات والملفات وروابط التحميل.', icon: 'fas fa-box-open', count: stats.value.resources, active: 'border-amber-300/25 bg-amber-400/10', pill: 'border-amber-300/20 bg-amber-400/10 text-amber-100', badgeClass: 'border-amber-300/20 bg-amber-400/10 text-amber-100', iconClass: 'bg-amber-400/12 text-amber-100 ring-amber-300/20' },
  { key: 'messages', label: 'الرسائل', desc: 'الوارد من العملاء والمتابعين.', icon: 'fas fa-inbox', count: stats.value.messages, active: 'border-emerald-300/25 bg-emerald-400/10', pill: 'border-emerald-300/20 bg-emerald-400/10 text-emerald-100', badgeClass: 'border-emerald-300/20 bg-emerald-400/10 text-emerald-100', iconClass: 'bg-emerald-400/12 text-emerald-100 ring-emerald-300/20' },
])

const activeTabMeta = computed(() => tabs.value.find((tab) => tab.key === activeTab.value) || tabs.value[0])
const filteredItems = computed(() => {
  let list = projects.value
  if (activeTab.value === 'projects') list = list.filter((item) => item.type !== 'resource')
  if (activeTab.value === 'resources') list = list.filter((item) => item.type === 'resource')
  const query = normalize(searchQuery.value)
  return !query ? list : list.filter((item) => [item.title, item.category, item.desc, item.fullDesc, item.type].some((field) => normalize(field).includes(query)))
})
const filteredMessages = computed(() => {
  const query = normalize(searchQuery.value)
  return !query ? messages.value : messages.value.filter((message) => [message.name, message.email, message.message].some((field) => normalize(field).includes(query)))
})
const featuredItem = computed(() => filteredItems.value[0] || projects.value[0] || null)
const latestMessage = computed(() => messages.value[0] || null)
const canCreate = computed(() => activeTab.value !== 'messages')
const primaryActionLabel = computed(() => activeTab.value === 'resources' ? 'إضافة مصدر جديد' : 'إضافة مشروع جديد')
const searchPlaceholder = computed(() => activeTab.value === 'messages' ? 'ابحث بالاسم أو البريد أو محتوى الرسالة...' : 'ابحث بالعنوان أو التصنيف أو الوصف...')
const resultsLabel = computed(() => `${formatNumber(activeTab.value === 'messages' ? filteredMessages.value.length : filteredItems.value.length)} ${activeTab.value === 'messages' ? 'رسالة' : activeTab.value === 'resources' ? 'مورد' : 'مشروع'} في العرض الحالي`)
const lastUpdatedLabel = computed(() => lastUpdated.value ? formatDate(lastUpdated.value) : 'لم يتم التحديث بعد')
const summaryCards = computed(() => [
  { key: 'projects', label: 'المشاريع', value: stats.value.projects, hint: 'عناصر قابلة للتحرير والنشر.', icon: 'fas fa-layer-group', shell: 'border-cyan-300/15 bg-cyan-400/8', iconClass: 'bg-cyan-400/12 text-cyan-100 ring-cyan-300/20' },
  { key: 'resources', label: 'المصادر', value: stats.value.resources, hint: 'ملفات وأدوات وروابط جاهزة.', icon: 'fas fa-toolbox', shell: 'border-amber-300/15 bg-amber-400/8', iconClass: 'bg-amber-400/12 text-amber-100 ring-amber-300/20' },
  { key: 'downloads', label: 'التحميلات', value: stats.value.downloads, hint: 'قياس بسيط للأداء الحالي.', icon: 'fas fa-download', shell: 'border-emerald-300/15 bg-emerald-400/8', iconClass: 'bg-emerald-400/12 text-emerald-100 ring-emerald-300/20' },
  { key: 'messages', label: 'الرسائل', value: stats.value.messages, hint: 'الوارد الحالي من نموذج التواصل.', icon: 'fas fa-envelope-open-text', shell: 'border-fuchsia-300/15 bg-fuchsia-400/8', iconClass: 'bg-fuchsia-400/12 text-fuchsia-100 ring-fuchsia-300/20' },
])

const selectTab = (key) => { activeTab.value = key }
const openModal = (project = null) => { selectedProject.value = project; showModal.value = true }
const closeModal = () => { showModal.value = false; selectedProject.value = null }
const handleSaved = async () => { await loadData(true) }

const loadData = async (silent = false) => {
  const token = getToken()
  if (!token) return goToLogin()
  if (silent) refreshing.value = true
  else loading.value = true
  errorMessage.value = ''
  try {
    const [projectsResult, messagesResult] = await Promise.allSettled([
      axios.get('/api/projects', { headers: { Accept: 'application/json' } }),
      axios.get('/api/messages', { headers: { Accept: 'application/json', Authorization: `Bearer ${token}` } }),
    ])
    if (projectsResult.status === 'fulfilled') projects.value = Array.isArray(projectsResult.value.data) ? projectsResult.value.data : []
    else errorMessage.value = 'تعذر تحميل المشاريع حالياً.'
    if (messagesResult.status === 'fulfilled') messages.value = Array.isArray(messagesResult.value.data) ? messagesResult.value.data : []
    else if (messagesResult.reason?.response?.status === 401) return goToLogin()
    else errorMessage.value = errorMessage.value ? `${errorMessage.value} وتعذر تحميل الرسائل أيضاً.` : 'تعذر تحميل الرسائل حالياً.'
    lastUpdated.value = new Date().toISOString()
  } catch (error) {
    console.error('Dashboard load error:', error)
    errorMessage.value = 'حدث خطأ غير متوقع أثناء تحديث لوحة التحكم.'
  } finally {
    loading.value = false
    refreshing.value = false
  }
}

const refreshData = async () => { await loadData(true) }

const deleteProject = async (id) => {
  if (!confirm('هل تريد حذف هذا العنصر نهائياً؟')) return
  const token = getToken()
  if (!token) return goToLogin()
  deletingKey.value = `project-${id}`
  try {
    await axios.delete(`/api/projects/${id}`, { headers: { Authorization: `Bearer ${token}` } })
    await loadData(true)
  } catch (error) {
    console.error('Delete project error:', error)
    if (error?.response?.status === 401) return goToLogin()
    errorMessage.value = 'تعذر حذف العنصر. حاول مرة أخرى.'
  } finally {
    deletingKey.value = ''
  }
}

const deleteMessage = async (id) => {
  if (!confirm('هل تريد حذف هذه الرسالة؟')) return
  const token = getToken()
  if (!token) return goToLogin()
  deletingKey.value = `message-${id}`
  try {
    await axios.delete(`/api/messages/${id}`, { headers: { Authorization: `Bearer ${token}` } })
    await loadData(true)
  } catch (error) {
    console.error('Delete message error:', error)
    if (error?.response?.status === 401) return goToLogin()
    errorMessage.value = 'تعذر حذف الرسالة. حاول مرة أخرى.'
  } finally {
    deletingKey.value = ''
  }
}

const copyEmail = async (email) => {
  try { await navigator.clipboard.writeText(email) } catch (error) {
    console.error('Copy email error:', error)
    errorMessage.value = 'تعذر نسخ البريد الإلكتروني من هذا المتصفح.'
  }
}

const logout = async () => {
  loggingOut.value = true
  try {
    const token = getToken()
    if (token) await axios.post('/api/logout', {}, { headers: { Authorization: `Bearer ${token}` } })
  } catch (error) {
    console.error('Logout error:', error)
  } finally {
    localStorage.removeItem('admin_token')
    loggingOut.value = false
    router.push('/admin/login')
  }
}

watch(activeTab, () => { searchQuery.value = '' })
onMounted(() => { if (!getToken()) goToLogin(); else loadData() })
</script>
