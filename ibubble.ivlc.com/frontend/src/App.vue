<template>
  <div>
    <select v-model="currentLang" @change="changeLang">
      <option value="en-US">English</option>
      <option value="zh-TW">繁體中文</option>
    </select>
    <AccountSettings :t="t" />
    <PushNotification :t="t" />
  </div>
</template>

<script>
import { ref, watch } from 'vue'
import AccountSettings from './components/AccountSettings.vue'
import PushNotification from './components/PushNotification.vue'
import { setLanguage, t as translate } from './utils/i18n'

export default {
  components: { AccountSettings, PushNotification },
  setup() {
    const currentLang = ref('en-US')
    watch(currentLang, (newLang) => {
      setLanguage(newLang)
    })
    const t = (...args) => translate(...args)
    return { currentLang, changeLang: (e) => currentLang.value = e.target.value, t }
  }
}
</script>
