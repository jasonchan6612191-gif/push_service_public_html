import { createI18n } from "vue-i18n";

const messages = {
  "zh-TW": {
    push_service_management: "推播服務管理",
    role: "角色",
    all: "全部",
    teacher: "老師",
    org: "機構",
    student: "學生",
    common: {
      success: "操作成功",
      fail: "操作失敗",
    },
    third_party_account: "第三方帳號綁定",
    local_account: "本地帳號",
    mobile_otp: "手機 OTP",
    password: "密碼",
    account_merge: "帳號合併",
    link: "綁定",
    unlink: "解除綁定",
    edit: "編輯",
    resend_otp: "重新發送 OTP",
    verify_otp: "驗證 OTP",
    change_password: "變更密碼",
    merge: "合併",
  },
  "en-US": {
    push_service_management: "Push Service Management",
    role: "Role",
    all: "All",
    teacher: "Teacher",
    org: "Organization",
    student: "Student",
    common: {
      success: "Success",
      fail: "Failed",
    },
    third_party_account: "Third-Party Account Bind",
    local_account: "Local Account",
    mobile_otp: "Mobile OTP",
    password: "Password",
    account_merge: "Account Merge",
    link: "Link",
    unlink: "Unlink",
    edit: "Edit",
    resend_otp: "Resend OTP",
    verify_otp: "Verify OTP",
    change_password: "Change Password",
    merge: "Merge",
  },
};

const i18n = createI18n({
  legacy: false,
  locale: "zh-TW",
  fallbackLocale: "en-US",
  messages,
});

export default i18n;
