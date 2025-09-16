<template>
    <div v-if="message" class="toast" :class="type">{{ message }}</div>
</template>
<script>
export default {
    props: ['message', 'type']
}
</script>
<style scoped>
.toast {
    position: fixed;
    top: 24px;
    right: 24px;
    min-width: 180px;
    padding: 12px 18px;
    border-radius: 4px;
    font-weight: bold;
    z-index: 1001;
    transition: all .3s;
}

.toast.success {
    background: #4caf50;
    color: #fff;
}

.toast.error {
    background: #f44336;
    color: #fff;
}
</style>
