<template>
    <div>
        <h2>{{ t('push.title') }}</h2>
        <label>{{ t('push.selectRole') }}
            <select v-model="selectedRole">
                <option value="all">{{ t('push.all') }}</option>
                <option value="teacher">{{ t('roles.teacher') }}</option>
                <option value="org">{{ t('roles.org') }}</option>
                <option value="student">{{ t('roles.student') }}</option>
            </select>
        </label>
        <label>{{ t('push.selectLanguage') }}
            <select v-model="selectedLanguage">
                <option v-for="(label, lang) in languages" :key="lang" :value="lang">{{ label }}</option>
            </select>
        </label>
        <ul>
            <li v-for="tag in filteredTags" :key="tag.id">{{ tag.name }} ({{ tag.role }})</li>
        </ul>
    </div>
</template>
<script>
import { getTags } from '../api'
import { t } from '../utils/i18n'
export default {
    data() {
        return {
            tags: [],
            selectedRole: 'all',
            selectedLanguage: 'en-US',
            languages: { 'en-US': 'English', 'zh-TW': '繁體中文' },
        }
    },
    computed: {
        filteredTags() {
            if (this.selectedRole === 'all') return this.tags
            return this.tags.filter(t => t.role === this.selectedRole)
        },
        t() { return t }
    },
    async created() {
        this.tags = await getTags()
    }
}
</script>
