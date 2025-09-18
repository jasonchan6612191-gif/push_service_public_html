const basePath = "/api";

export async function linkAccount(provider) {
  return fetch(`${basePath}/link`, {
    method: "POST",
    body: JSON.stringify({ provider }),
    headers: { "Content-Type": "application/json" },
  });
}
export async function unlinkAccount() {
  return fetch(`${basePath}/unlink`, { method: "POST" });
}
export async function editAccount(data) {
  return fetch(`${basePath}/account/edit`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
}
export async function unbindAccount() {
  return fetch(`${basePath}/account/unbind`, { method: "POST" });
}
export async function sendOtp(phone) {
  return fetch(`${basePath}/otp/send`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ phone }),
  });
}
export async function verifyOtp(code) {
  return fetch(`${basePath}/otp/verify`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ code }),
  });
}
export async function unbindOtp() {
  return fetch(`${basePath}/otp/unbind`, { method: "POST" });
}
export async function changePassword(data) {
  return fetch(`${basePath}/password/change`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
}
export async function mergeAccount(email) {
  return fetch(`${basePath}/merge`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ email }),
  });
}
export async function getTags() {
  return fetch(`${basePath}/tags`).then((res) => res.json());
}
export async function getUsersByTag(tagId) {
  return fetch(`${basePath}/users?tag=${tagId}`).then((res) => res.json());
}
