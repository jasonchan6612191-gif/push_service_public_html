<template>
    <div class="card-container">
        <div class="card">
            <div class="left">第三方帳號綁定</div>
            <div class="right">
                <button class="btn confirm" @click="openModal('link')"><span>🔗</span> 綁定</button>
                <button class="btn error" @click="openModal('unlink')"><span>🗑️</span> 解除綁定</button>
            </div>
        </div>

        <div class="card">
            <div class="left">本地帳號</div>
            <div class="right">
                <button class="btn confirm" @click="openModal('edit')"><span>✏️</span> 編輯</button>
                <button class="btn error" @click="openModal('unbindAccount')"><span>🗑️</span> 解除綁定</button>
            </div>
        </div>

        <div class="card">
            <div class="left">手機 OTP</div>
            <div class="right">
                <button class="btn confirm" @click="openModal('sendOtp')"><span>📲</span> 重新發送 OTP</button>
                <button class="btn confirm" @click="openModal('verifyOtp')"><span>✔️</span> 驗證 OTP</button>
                <button class="btn error" @click="openModal('unbindOtp')"><span>🗑️</span> 解除綁定</button>
            </div>
        </div>

        <div class="card">
            <div class="left">密碼</div>
            <div class="right">
                <button class="btn confirm" @click="openModal('changePassword')"><span>🔒</span> 變更密碼</button>
            </div>
        </div>

        <div class="card">
            <div class="left">帳號合併</div>
            <div class="right">
                <button class="btn confirm" @click="openModal('merge')"><span>🔄</span> 合併</button>
            </div>
        </div>

        <Modal :show="modalShow" @cancel="modalShow = false" @confirm="handleConfirm" />
        <Toast :message="toast.msg" :type="toast.type" />
    </div>
</template>

<script>
import Modal from './Modal.vue'
import Toast from './Toast.vue'

import {
    linkAccount,
    unlinkAccount,
    editAccount,
    unbindAccount,
    sendOtp,
    verifyOtp,
    unbindOtp,
    changePassword,
    mergeAccount,
} from '../api'

import { useI18n } from 'vue-i18n' // 假設使用vue-i18n

export default {
    components: { Modal, Toast },
    setup() {
        const { locale } = useI18n()
        return { locale }
    },
    data() {
        return {
            modalShow: false,
            currentAction: '',
            toast: { msg: '', type: '' },
        }
    },
    methods: {
        openModal(action) {
            this.currentAction = action
            this.modalShow = true
        },
        async handleConfirm() {
            try {
                switch (this.currentAction) {
                    case 'link': await linkAccount('google'); break;
                    case 'unlink': await unlinkAccount(); break;
                    case 'edit': await editAccount({ name: 'new' }); break;
                    case 'unbindAccount': await unbindAccount(); break;
                    case 'sendOtp': await sendOtp('0912345678'); break;
                    case 'verifyOtp': await verifyOtp('123456'); break;
                    case 'unbindOtp': await unbindOtp(); break;
                    case 'changePassword': await changePassword({ pwd: 'newpwd' }); break;
                    case 'merge': await mergeAccount('test@example.com'); break;
                }
                this.toast = { msg: this.$t('common.success'), type: 'success' }
            } catch {
                this.toast = { msg: this.$t('common.fail'), type: 'error' }
            }
            this.modalShow = false
            setTimeout(() => (this.toast = { msg: '', type: '' }), 1500)
        }
    }
}
</script>

<style scoped>
.card-container {
    display: flex;
    flex-direction: column;
    gap: 24px;
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
    height: 80px;
    box-shadow: 0 3px 16px rgba(0, 0, 0, 0.35);
    transition: box-shadow 0.25s ease, transform 0.25s ease;
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
}

.right {
    display: flex;
    gap: 22px;
}

.btn {
    font-size: 19px;
    padding: 10px 28px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    color: white;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.btn.confirm {
    background-color: #2196f3;
    box-shadow: 0 3px 10px rgba(33, 150, 243, 0.7);
}

.btn.confirm:hover {
    background-color: #1976d2;
    box-shadow: 0 5px 17px rgba(25, 118, 210, 0.9);
}

.btn.error {
    background-color: #f44336;
    box-shadow: 0 3px 10px rgba(244, 67, 54, 0.7);
}

.btn.error:hover {
    background-color: #d32f2f;
    box-shadow: 0 5px 17px rgba(211, 47, 47, 0.9);
}
</style>
