<template>
  <div class="p-6 max-w-3xl mx-auto space-y-8">
    <div class="mb-6 flex items-center gap-4">
      <select v-model="selectedLang" @change="changeLanguage" class="border p-2 rounded w-36">
        <option value="zh-TW">繁體中文</option>
        <option value="en-US">English</option>
      </select>
      <button @click="changeLanguage" class="bg-blue-600 text-white px-4 py-2 rounded">
        切換語言
      </button>
    </div>

    <AccountSettings :t="t" />
    <PushNotification :t="t" />
  </div>
</template>

<script>
import { ref } from 'vue'
import AccountSettings from './components/AccountSettings.vue'
import PushNotification from './components/PushNotification.vue'
import { setLanguage, t as translate } from './utils/i18n'

export default {
  components: { AccountSettings, PushNotification },
  setup() {
    const selectedLang = ref('zh-TW')

    const changeLanguage = () => {
      setLanguage(selectedLang.value)
    }

    const t = (...args) => translate(...args)

    return { selectedLang, changeLanguage, t }
  }
}
</script>
