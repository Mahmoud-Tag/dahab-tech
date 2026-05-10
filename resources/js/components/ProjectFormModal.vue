<template>
  <div class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto bg-black/80 p-4 backdrop-blur-md" @click.self="$emit('close')">
    <div class="my-auto w-full max-w-2xl overflow-hidden rounded-3xl border border-gray-800 bg-gray-900 shadow-2xl">
      <div class="p-6 border-b border-gray-800 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-yellow-500">{{ project ? 'تعديل مشروع' : 'إضافة مشروع جديد' }}</h2>
        <button @click="$emit('close')" class="text-gray-400 hover:text-white transition">
          <i class="fas fa-times text-xl"></i>
        </button>
      </div>

      <form @submit.prevent="save" class="p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-1">
            <label class="text-sm text-gray-400">اسم المشروع</label>
            <input v-model="form.title" placeholder="مثال: متجر الأزياء الفاخرة" class="w-full bg-black border border-gray-800 p-3 rounded-xl outline-none focus:border-yellow-500 transition text-white" required>
          </div>
          <div class="space-y-1">
            <label class="text-sm text-gray-400">التصنيف</label>
            <input v-model="form.category" placeholder="مثال: تطبيقات موبايل" class="w-full bg-black border border-gray-800 p-3 rounded-xl outline-none focus:border-yellow-500 transition text-white" required>
          </div>
          <div class="space-y-1">
            <label class="text-sm text-gray-400">السنة</label>
            <input v-model="form.year" placeholder="مثال: 2024" class="w-full bg-black border border-gray-800 p-3 rounded-xl outline-none focus:border-yellow-500 transition text-white">
          </div>
          <div class="space-y-1">
            <label class="text-sm text-gray-400">نوع المشروع</label>
            <select v-model="form.type" class="w-full bg-black border border-gray-800 p-3 rounded-xl outline-none focus:border-yellow-500 transition text-white appearance-none">
              <option value="web">موقع ويب</option>
              <option value="app">تطبيق</option>
              <option value="system">نظام</option>
              <option value="ecommerce">متجر</option>
              <option value="ai">ذكاء اصطناعي</option>
              <option value="resource">مصدر / أداة (Resource)</option>
            </select>
          </div>
          <div class="space-y-1">
            <label class="text-sm text-gray-400">اللغات المستخدمة (افصل بينها بفاصلة , )</label>
            <input v-model="form.language" placeholder="مثال: PHP, Vue, React, MySQL" class="w-full bg-black border border-gray-800 p-3 rounded-xl outline-none focus:border-yellow-500 transition text-white">
          </div>
        </div>

        <div class="space-y-1">
          <label class="text-sm text-gray-400">وصف مخصر</label>
          <textarea v-model="form.desc" placeholder="وصف يظهر في بطاقة المشروع..." class="w-full bg-black border border-gray-800 p-3 rounded-xl outline-none focus:border-yellow-500 transition h-20 text-white"></textarea>
        </div>

        <div class="space-y-1">
          <label class="text-sm text-gray-400">تفاصيل المشروع بالكامل</label>
          <textarea v-model="form.fullDesc" placeholder="شرح مفصل للمميزات والتقنيات..." class="w-full bg-black border border-gray-800 p-3 rounded-xl outline-none focus:border-yellow-500 transition h-32 text-white"></textarea>
        </div>

        <div class="space-y-1">
          <label class="text-sm text-gray-400">رابط التحميل</label>
          <input v-model="form.downloadUrl" placeholder="https://..." class="w-full bg-black border border-gray-800 p-3 rounded-xl outline-none focus:border-yellow-500 transition text-white">
        </div>

        <div class="space-y-2">
          <label class="text-sm text-gray-400 block">صورة المشروع</label>
          <div class="flex items-center gap-4">
            <div v-if="previewImage || project?.image" class="w-20 h-20 rounded-lg overflow-hidden border border-gray-800 shrink-0">
              <img :src="previewImage || project?.image" class="w-full h-full object-cover">
            </div>
            <label class="flex-1 cursor-pointer">
              <span class="block w-full bg-gray-800 hover:bg-gray-700 text-center p-3 rounded-xl text-sm transition">
                <i class="fas fa-cloud-upload-alt mr-2"></i> اختار صورة
              </span>
              <input type="file" @change="handleFile" class="hidden" accept="image/*">
            </label>
          </div>
        </div>

        <div class="flex gap-4 pt-4 border-t border-gray-800">
          <button type="submit" class="flex-1 bg-yellow-500 text-black font-bold p-4 rounded-xl hover:bg-yellow-600 transition shadow-lg shadow-yellow-500/20" :disabled="loading">
            <span v-if="loading"><i class="fas fa-spinner fa-spin mr-2"></i> جاري الحفظ...</span>
            <span v-else>حفظ التغييرات</span>
          </button>
          <button @click="$emit('close')" type="button" class="px-8 border border-gray-700 rounded-xl hover:bg-white/5 transition text-gray-300">إلغاء</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps(['project', 'defaultType'])
const emit = defineEmits(['close', 'saved'])

const form = ref({
  title: '',
  category: '',
  desc: '',
  fullDesc: '',
  year: '',
  type: 'web',
  language: '',
  downloadUrl: '',
  image: null,
  tags: [],
  features: []
})
const previewImage = ref(null)
const loading = ref(false)

onMounted(() => {
  if (props.project) {
    // Fill form with project data
    form.value.title = props.project.title || ''
    form.value.category = props.project.category || ''
    form.value.desc = props.project.desc || ''
    form.value.fullDesc = props.project.fullDesc || ''
    form.value.year = props.project.year || ''
    form.value.type = props.project.type || 'web'
    form.value.language = props.project.language || ''
    form.value.downloadUrl = props.project.downloadUrl || ''
    form.value.tags = props.project.tags || []
    form.value.features = props.project.features || []
    // Note: form.image remains null unless changed by user
  } else if (props.defaultType) {
    form.value.type = props.defaultType
  }
})

const handleFile = (e) => {
  const file = e.target.files[0]
  if (file) {
    form.value.image = file
    previewImage.value = URL.createObjectURL(file)
  }
}

const save = async () => {
  loading.value = true
  const token = localStorage.getItem('admin_token')
  if (!token) {
    localStorage.removeItem('admin_token')
    window.location.href = '/admin/login'
    return
  }
  const formData = new FormData()

  // Basic fields
  formData.append('title', form.value.title)
  formData.append('category', form.value.category)
  formData.append('desc', form.value.desc)
  formData.append('fullDesc', form.value.fullDesc)
  formData.append('year', form.value.year)
  formData.append('type', form.value.type)
  formData.append('language', form.value.language)
  formData.append('downloadUrl', form.value.downloadUrl)

  // Handle file
  if (form.value.image instanceof File) {
    formData.append('image', form.value.image)
  }

  // Handle arrays (tags and features default to empty if not set)
  formData.append('tags', JSON.stringify(form.value.tags))
  formData.append('features', JSON.stringify(form.value.features))

  // Method Spoofing for PUT in Laravel with FormData
  if (props.project) {
    formData.append('_method', 'PUT')
  }

  try {
    const url = props.project ? `/api/projects/${props.project.id}` : '/api/projects'
    await axios.post(url, formData, {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'multipart/form-data'
      }
    })
    emit('saved')
    emit('close')
  } catch (err) {
    console.error('Error saving project:', err.response?.data || err.message)
    if (err?.response?.status === 401) {
      localStorage.removeItem('admin_token')
      window.location.href = '/admin/login'
      return
    }
    alert('حدث خطأ أثناء الحفظ: ' + (err.response?.data?.message || err.message))
  } finally {
    loading.value = false
  }
}
</script>
