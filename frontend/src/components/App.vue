<template>
  <div class="card-container">
    <div class="card">
      <div class="left">{{ t('push_service_management') }}</div>
      <div class="right">
        <label>
          {{ t('role') }}
          <select v-model="selectedRole" class="select">
            <option value="all">{{ t('all') }}</option>
            <option value="teacher">{{ t('teacher') }}</option>
            <option value="org">{{ t('org') }}</option>
            <option value="student">{{ t('student') }}</option>
          </select>
        </label>
        <button class="btn lang-switch" @click="switchLanguage">
          {{ locale === 'zh-TW' ? 'English' : '繁體中文' }}
        </button>
      </div>
    </div>

    <div class="card">
      <div class="left">{{ t('third_party_account') }}</div>
      <div class="right">
        <button class="btn confirm" @click="openModal('link')">
          <span>🔗</span> {{ t('link') }}
        </button>
        <button class="btn error" @click="openModal('unlink')">
          <span>🗑️</span> {{ t('unlink') }}
        </button>
      </div>
    </div>

    <div class="card">
      <div class="left">{{ t('local_account') }}</div>
      <div class="right">
        <button class="btn confirm" @click="openModal('edit')">
          <span>✏️</span> {{ t('edit') }}
        </button>
        <button class="btn error" @click="openModal('unbindAccount')">
          <span>🗑️</span> {{ t('unlink') }}
        </button>
      </div>
    </div>

    <div class="card">
      <div class="left">{{ t('mobile_otp') }}</div>
      <div class="right">
        <button class="btn confirm" @click="openModal('sendOtp')">
          <span>📲</span> {{ t('resend_otp') }}
        </button>
        <button class="btn confirm" @click="openModal('verifyOtp')">
          <span>✔️</span> {{ t('verify_otp') }}
        </button>
        <button class="btn error" @click="openModal('unbindOtp')">
          <span>🗑️</span> {{ t('unlink') }}
        </button>
      </div>
    </div>

    <div class="card">
      <div class="left">{{ t('password') }}</div>
      <div class="right">
        <button class="btn confirm" @click="openModal('changePassword')">
          <span>🔒</span> {{ t('change_password') }}
        </button>
      </div>
    </div>

    <div class="card">
      <div class="left">{{ t('account_merge') }}</div>
      <div class="right">
        <button class="btn confirm" @click="openModal('merge')">
          <span>🔄</span> {{ t('merge') }}
        </button>
      </div>
    </div>

    <Modal :show="modalShow" @cancel="modalShow = false" @confirm="handleConfirm" />
    <Toast :message="toast.msg" :type="toast.type" />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import Modal from './Modal.vue';
import Toast from './Toast.vue';

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
} from '../api';

const { t, locale } = useI18n();

const selectedRole = ref('all');
const modalShow = ref(false);
const currentAction = ref('');
const toast = ref({ msg: '', type: '' });

function switchLanguage() {
  locale.value = locale.value === 'zh-TW' ? 'en-US' : 'zh-TW';
}

function openModal(action) {
  currentAction.value = action;
  modalShow.value = true;
}

async function handleConfirm() {
  try {
    switch (currentAction.value) {
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
    toast.value = { msg: t('common.success'), type: 'success' };
  } catch {
    toast.value = { msg: t('common.fail'), type: 'error' };
  }
  modalShow.value = false;
  setTimeout(() => { toast.value = { msg: '', type: '' }; }, 1500);
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
