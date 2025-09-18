<template>
    <div>
        <h2>{{ t('account.title') }}</h2>
        <div class="section">
            <h3>{{ t('account.thirdPartyLinking') }}</h3>
            <button class="btn confirm" @click="openModal('link')"><span>🔗</span> {{ t('account.link') }}</button>
            <button class="btn error" @click="openModal('unlink')"><span>🗑️</span> {{ t('account.unlink') }}</button>
        </div>
        <div class="section">
            <h3>{{ t('account.nativeAccount') }}</h3>
            <button class="btn confirm" @click="openModal('edit')"><span>✏️</span> {{ t('account.edit') }}</button>
            <button class="btn error" @click="openModal('unbindAccount')"><span>🗑️</span> {{ t('account.unbind')
                }}</button>
        </div>
        <div class="section">
            <h3>{{ t('account.phoneOtp') }}</h3>
            <button class="btn confirm" @click="openModal('sendOtp')"><span>📲</span> {{ t('account.resendOtp')
                }}</button>
            <button class="btn confirm" @click="openModal('verifyOtp')"><span>✔️</span> {{ t('account.verifyOtp')
                }}</button>
            <button class="btn error" @click="openModal('unbindOtp')"><span>🗑️</span> {{ t('account.unbindOtp')
                }}</button>
        </div>
        <div class="section">
            <h3>{{ t('account.password') }}</h3>
            <button class="btn confirm" @click="openModal('changePassword')"><span>🔒</span> {{
                t('account.changePassword') }}</button>
        </div>
        <div class="section">
            <h3>{{ t('account.merge') }}</h3>
            <button class="btn confirm" @click="openModal('merge')"><span>🔄</span> {{ t('account.merge') }}</button>
        </div>
        <Modal :show="modalShow" @cancel="modalShow = false" @confirm="handleConfirm"></Modal>
        <Toast :message="toast.msg" :type="toast.type" />
    </div>
</template>

<script>
import Modal from './Modal.vue'
import Toast from './Toast.vue'
import {
    linkAccount, unlinkAccount, editAccount,
    unbindAccount, sendOtp, verifyOtp, unbindOtp,
    changePassword, mergeAccount
} from '../api'

export default {
    components: { Modal, Toast },
    props: ['t'],
    data() {
        return { modalShow: false, currentAction: '', toast: { msg: '', type: '' } }
    },
    methods: {
        openModal(action) {
            this.currentAction = action
            this.modalShow = true
        },
        async handleConfirm() {
            let res
            try {
                if (this.currentAction === 'link') res = await linkAccount('google')
                if (this.currentAction === 'unlink') res = await unlinkAccount()
                if (this.currentAction === 'edit') res = await editAccount({ name: 'new' })
                if (this.currentAction === 'unbindAccount') res = await unbindAccount()
                if (this.currentAction === 'sendOtp') res = await sendOtp('0912345678')
                if (this.currentAction === 'verifyOtp') res = await verifyOtp('123456')
                if (this.currentAction === 'unbindOtp') res = await unbindOtp()
                if (this.currentAction === 'changePassword') res = await changePassword({ pwd: 'newpwd' })
                if (this.currentAction === 'merge') res = await mergeAccount('test@example.com')
                this.toast = { msg: this.t('common.success'), type: 'success' }
            } catch {
                this.toast = { msg: this.t('common.fail'), type: 'error' }
            }
            this.modalShow = false
            setTimeout(() => this.toast = { msg: '', type: '' }, 1500)
        }
    }
}
</script>

<style scoped>
.section {
    margin-bottom: 24px;
}

.btn {
    margin: 6px 6px 0 0;
    padding: 8px 18px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    font-weight: 500;
    transition: .2s;
}

.btn.confirm {
    background: #2196f3;
    color: #fff;
}

.btn.error {
    background: #f44336;
    color: #fff;
}
</style>
