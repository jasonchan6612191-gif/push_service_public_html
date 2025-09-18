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
    background: rgba(40, 40, 40, 0.25);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 50;
}

.modal-content {
    background: #fff;
    padding: 28px;
    border-radius: 16px;
    min-width: 360px;
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.10), 0 1.5px 6px rgba(0, 0, 0, 0.10);
}

.modal-actions {
    margin-top: 28px;
    display: flex;
    gap: 16px;
    justify-content: flex-end;
}

.btn {
    padding: 10px 24px;
    font-size: 1rem;
    border: none;
    border-radius: 8px;
    outline: none;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.18s;
}

.btn.cancel {
    background: #f4f6f8;
    color: #1a1a1a;
}

.btn.confirm {
    background: #2563eb;
    color: #fff;
}

.btn.confirm:hover {
    background: #1e40af;
}

.btn.cancel:hover {
    background: #e2e8f0;
}
</style>
