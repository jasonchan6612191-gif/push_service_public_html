import enUS from "../i18n/en-US.json";
import zhTW from "../i18n/zh-TW.json";

const languages = { "en-US": enUS, "zh-TW": zhTW };
let currentLang = "en-US";

export function detectLanguage() {
  const lang = navigator.language || "en-US";
  return languages[lang] ? lang : "en-US";
}

export function t(key) {
  const keys = key.split(".");
  let text = languages[currentLang];
  for (const k of keys) text = text ? text[k] : null;
  return text || key;
}

export function setLanguage(lang) {
  if (languages[lang]) currentLang = lang;
}

export function initLanguage() {
  currentLang = detectLanguage();
}
