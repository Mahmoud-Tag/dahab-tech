<template>
  <div class="min-h-screen bg-black text-white font-['Cairo'] flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 border-l border-gray-800 p-6  flex-col hidden md:flex">
      <h1 class="text-2xl font-bold text-yellow-500 mb-10 flex items-center gap-2">
        <i class="fas fa-gem text-xl"></i>
        <span>داشبورد دهب</span>
      </h1>
      <nav class="flex-1 space-y-4">
        <a href="#" @click.prevent="currentTab = 'projects'" :class="['flex items-center gap-3 p-3 rounded-lg border transition', currentTab === 'projects' ? 'text-yellow-500 bg-yellow-500/10 border-yellow-500/20' : 'text-gray-400 hover:text-white border-transparent']">
          <i class="fas fa-project-diagram"></i>
          المشاريع
        </a>
        <a href="#" @click.prevent="currentTab = 'resources'" :class="['flex items-center gap-3 p-3 rounded-lg border transition', currentTab === 'resources' ? 'text-yellow-500 bg-yellow-500/10 border-yellow-500/20' : 'text-gray-400 hover:text-white border-transparent']">
          <i class="fas fa-box-open"></i>
          المصادر (Resources)
        </a>
        <a href="#" @click.prevent="currentTab = 'messages'" :class="['flex items-center gap-3 p-3 rounded-lg border transition', currentTab === 'messages' ? 'text-yellow-500 bg-yellow-500/10 border-yellow-500/20' : 'text-gray-400 hover:text-white border-transparent']">
          <i class="fas fa-envelope"></i>
          الرسائل (Inbox)
          <span v-if="messages.length" class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full mr-auto">{{ messages.length }}</span>
        </a>
      </nav>
      <button @click="logout" class="mt-auto flex items-center gap-3 text-red-400 hover:text-red-300 transition p-3">
        <i class="fas fa-sign-out-alt"></i>
        تسجيل الخروج
      </button>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-10 overflow-y-auto">
      <!-- Stats Row -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <div class="bg-gray-900/50 border border-gray-800 p-4 rounded-2xl flex items-center gap-4">
          <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500"><i class="fas fa-project-diagram"></i></div>
          <div><p class="text-xs text-gray-500">المشاريع</p><p class="text-xl font-bold">{{ stats.projects }}</p></div>
        </div>
        <div class="bg-gray-900/50 border border-gray-800 p-4 rounded-2xl flex items-center gap-4">
          <div class="w-12 h-12 bg-yellow-500/10 rounded-xl flex items-center justify-center text-yellow-500"><i class="fas fa-box-open"></i></div>
          <div><p class="text-xs text-gray-500">المصادر</p><p class="text-xl font-bold">{{ stats.resources }}</p></div>
        </div>
        <div class="bg-gray-900/50 border border-gray-800 p-4 rounded-2xl flex items-center gap-4">
          <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center text-green-500"><i class="fas fa-download"></i></div>
          <div><p class="text-xs text-gray-500">التحميلات</p><p class="text-xl font-bold">{{ stats.downloads }}</p></div>
        </div>
        <div class="bg-gray-900/50 border border-gray-800 p-4 rounded-2xl flex items-center gap-4">
          <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center text-red-500"><i class="fas fa-envelope"></i></div>
          <div><p class="text-xs text-gray-500">الرسائل</p><p class="text-xl font-bold">{{ stats.messages }}</p></div>
        </div>
      </div>

      <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
          <h2 class="text-3xl font-bold text-white mb-2">{{ tabTitle }}</h2>
          <p class="text-gray-400">{{ tabSubtitle }}</p>
        </div>
        <div class="flex items-center gap-4 w-full md:w-auto">
          <div class="relative flex-1 md:w-64">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
            <input v-model="searchQuery" :placeholder="searchPlaceholder" class="w-full bg-gray-900 border border-gray-800 pl-10 pr-4 py-2.5 rounded-xl outline-none focus:border-yellow-500/50 text-sm">
          </div>
          <button v-if="currentTab !== 'messages'" @click="openModal()" class="bg-yellow-500 text-black font-bold px-6 py-3 rounded-xl hover:bg-yellow-600 transition flex items-center gap-2 shadow-[0_0_20px_rgba(234,179,8,0.3)] shrink-0">
            <i class="fas fa-plus"></i>
            {{ currentTab === 'projects' ? 'مشروع جديد' : 'مصدر جديد' }}
          </button>
        </div>
      </div>

      <!-- Messages Table -->
      <div v-if="currentTab === 'messages'" class="space-y-4">
        <div v-if="loading" class="flex justify-center items-center py-20">
          <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-yellow-500"></div>
        </div>
        <div v-else-if="filteredMessages.length === 0" class="text-center py-20 bg-gray-900/50 rounded-3xl border border-dashed border-gray-800">
          <i class="fas fa-envelope-open text-5xl text-gray-700 mb-4"></i>
          <p class="text-gray-500">لا يوجد رسائل حالياً</p>
        </div>
        <div v-else class="grid grid-cols-1 gap-4">
          <div v-for="msg in filteredMessages" :key="msg.id" class="bg-gray-900 border border-gray-800 rounded-2xl p-6 hover:border-yellow-500/40 transition group">
            <div class="flex justify-between items-start mb-4">
              <div>
                <h3 class="text-lg font-bold">{{ msg.name }}</h3>
                <p class="text-sm text-yellow-500">{{ msg.email }}</p>
              </div>
              <button @click="deleteMessage(msg.id)" class="text-gray-600 hover:text-red-500 transition">
                <i class="fas fa-trash"></i>
              </button>
            </div>
            <p class="text-gray-400 text-sm leading-relaxed">{{ msg.message }}</p>
            <p class="text-[10px] text-gray-600 mt-4">{{ new Date(msg.created_at).toLocaleString('ar-EG') }}</p>
          </div>
        </div>
      </div>

      <!-- Projects/Resources Grid -->
      <div v-else>
        <div v-if="loading" class="flex justify-center items-center py-20">
          <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-yellow-500"></div>
        </div>

        <div v-else-if="filteredItems.length === 0" class="text-center py-20 bg-gray-900/50 rounded-3xl border border-dashed border-gray-800">
          <i class="fas fa-folder-open text-5xl text-gray-700 mb-4"></i>
          <p class="text-gray-500">لا يوجد بيانات مطابقة للبحث</p>
        </div>

        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="project in filteredItems" :key="project.id" class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden hover:border-yellow-500/40 transition group relative">
            <div class="aspect-video relative overflow-hidden bg-black/40">
              <img :src="project.image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="">
              <div class="absolute top-2 right-2 px-3 py-1 bg-black/60 backdrop-blur-md rounded-lg text-xs text-yellow-500 border border-yellow-500/20">
                {{ project.category }}
              </div>
            </div>
            <div class="p-5">
              <h3 class="text-lg font-bold mb-4 line-clamp-1">{{ project.title }}</h3>
              <div class="flex gap-2">
                <button @click="openModal(project)" class="flex-1 bg-gray-800 hover:bg-gray-700 p-2 rounded-lg text-sm text-yellow-500 transition border border-yellow-500/10">
                  <i class="fas fa-edit mr-1"></i> تعديل
                </button>
                <button @click="deleteProject(project.id)" class="flex-1 bg-red-900/10 hover:bg-red-900/30 p-2 rounded-lg text-sm text-red-500 transition border border-red-500/10">
                  <i class="fas fa-trash mr-1"></i> حذف
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <ProjectFormModal v-if="showModal" :project="selectedProject" :default-type="currentTab === 'resources' ? 'resource' : 'web'" @close="closeModal" @saved="fetchData" />
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import ProjectFormModal from '../components/ProjectFormModal.vue'

const router = useRouter()
const projects = ref([])
const messages = ref([])
const showModal = ref(false)
const selectedProject = ref(null)
const loading = ref(true)
const currentTab = ref('projects') // 'projects', 'resources', 'messages'
const searchQuery = ref('')

import { computed, watch } from 'vue'

const filteredItems = computed(() => {
  let items = projects.value
  if (currentTab.value === 'projects') {
    items = items.filter(p => p.type !== 'resource')
  } else if (currentTab.value === 'resources') {
    items = items.filter(p => p.type === 'resource')
  }
  
  if (searchQuery.value) {
    const q = searchQuery.value.toLowerCase()
    return items.filter(p => p.title.toLowerCase().includes(q) || p.category.toLowerCase().includes(q))
  }
  return items
})

const filteredMessages = computed(() => {
  if (searchQuery.value) {
    const q = searchQuery.value.toLowerCase()
    return messages.value.filter(m => m.name.toLowerCase().includes(q) || m.email.toLowerCase().includes(q) || m.message.toLowerCase().includes(q))
  }
  return messages.value
})

const stats = computed(() => ({
  projects: projects.value.filter(p => p.type !== 'resource').length,
  resources: projects.value.filter(p => p.type === 'resource').length,
  downloads: projects.value.reduce((acc, p) => acc + (p.downloads || 0), 0),
  messages: messages.value.length
}))

const tabTitle = computed(() => {
  if (currentTab.value === 'projects') return 'إدارة المشاريع'
  if (currentTab.value === 'resources') return 'إدارة المصادر'
  return 'صندوق الوارد'
})

const tabSubtitle = computed(() => {
  if (currentTab.value === 'projects') return 'يمكنك إضافة، تعديل أو حذف المشاريع من هنا.'
  if (currentTab.value === 'resources') return 'إدارة الملفات والأدوات القابلة للتحميل.'
  return 'استعرض رسايل العملاء وتواصل معهم.'
})

const searchPlaceholder = computed(() => {
  if (currentTab.value === 'messages') return 'بحث في الرسائل...'
  return 'بحث بالاسم أو التصنيف...'
})

const fetchData = async () => {
  loading.value = true
  try {
    const token = localStorage.getItem('admin_token')
    const [projectsRes, messagesRes] = await Promise.all([
      axios.get('/api/projects'),
      axios.get('/api/messages', { headers: { Authorization: `Bearer ${token}` } })
    ])
    projects.value = projectsRes.data
    messages.value = messagesRes.data
  } catch (err) {
    console.error('Error fetching data:', err)
  } finally {
    loading.value = false
  }
}

watch(currentTab, () => {
  searchQuery.value = ''
})

const openModal = (project = null) => {
  selectedProject.value = project
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  selectedProject.value = null
}

const deleteProject = async (id) => {
  if (!confirm('هل أنت متأكد من حذف هذا المشروع نهائياً؟')) return

  const token = localStorage.getItem('admin_token')
  try {
    await axios.delete(`/api/projects/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    })
    await fetchProjects()
  } catch (err) {
    alert('حدث خطأ أثناء محاولة الحذف')
  }
}

const deleteMessage = async (id) => {
  if (!confirm('هل تريد حذف هذه الرسالة؟')) return
  const token = localStorage.getItem('admin_token')
  try {
    await axios.delete(`/api/messages/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    })
    await fetchData()
  } catch (err) {
    alert('حدث خطأ أثناء الحذف')
  }
}

const logout = () => {
  localStorage.removeItem('admin_token')
  router.push('/admin/login')
}

onMounted(fetchData)
</script>
