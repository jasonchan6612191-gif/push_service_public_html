<template>
    <div v-if="show" class="modal">
        <div class="modal-content">
            <slot></slot>
            <div class="modal-actions">
                <button class="btn cancel" @click="$emit('cancel')">取消</button>
                <button class="btn confirm" @click="$emit('confirm')">確認</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['show']
}
</script>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: #fff;
    padding: 24px;
    border-radius: 4px;
    min-width: 320px;
}

.modal-actions {
    margin-top: 20px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn.cancel {
    background: #eee;
    color: #333;
}

.btn.confirm {
    background: #2196f3;
    color: #fff;
}
</style>