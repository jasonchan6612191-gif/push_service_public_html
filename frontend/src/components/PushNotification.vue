<template>
    <div class="card-container">
        <div class="card">
            <div class="left">推播服務管理</div>
            <div class="right">
                <label>
                    角色
                    <select v-model="selectedRole" class="select">
                        <option value="all">全部</option>
                        <option value="teacher">老師</option>
                        <option value="org">機構</option>
                        <option value="student">學生</option>
                    </select>
                </label>
                <button class="btn lang-switch" @click="switchLanguage">
                    {{ locale === 'zh-TW' ? 'English' : '繁體中文' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { useI18n } from 'vue-i18n'

export default {
    setup() {
        const { locale } = useI18n()
        const selectedRole = Vue.ref('all')
        const switchLanguage = () => {
            locale.value = locale.value === 'zh-TW' ? 'en-US' : 'zh-TW'
            // 這裡也可以觸發彈窗或其他確認
        }
        return {
            locale,
            selectedRole,
            switchLanguage,
        }
    },
}
</script>

<style scoped>
.card-container {
    display: flex;
    justify-content: center;
    width: 95vw;
    max-width: 840px;
    margin: 24px auto;
}

.card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #292929;
    border-radius: 12px;
    padding: 22px 36px;
    min-height: 80px;
    box-shadow: 0 3px 16px rgba(0, 0, 0, 0.35);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.card:hover {
    box-shadow: 0 9px 28px rgba(0, 0, 0, 0.65);
    transform: translateY(-9px);
}

.left {
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    user-select: none;
    text-align: left;
    width: 160px;
}

.right {
    display: flex;
    gap: 16px;
    align-items: center;
}

.select {
    margin-left: 8px;
    padding: 6px 14px;
    font-size: 16px;
    border-radius: 5px;
    border: none;
    background-color: #444;
    color: #fff;
}

.btn.lang-switch {
    font-size: 18px;
    padding: 8px 24px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    background-color: #607d8b;
    color: #fff;
    transition: background-color 0.3s ease;
}

.btn.lang-switch:hover {
    background-color: #455a64;
}
</style>
