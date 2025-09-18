<template>
    <div class="flex items-center justify-between bg-white p-4 rounded shadow">
        <div class="flex items-center gap-4">
            <img :src="`/icons/${provider.toLowerCase()}.svg`" :alt="provider" class="w-6 h-6" />
            <div>
                <div class="font-medium">{{ provider }}</div>
                <div :class="linked ? 'text-gray-500' : 'text-gray-400'" class="text-sm">
                    {{ linked ? email : '未連結' }}
                </div>
            </div>
        </div>
        <button v-if="linked" @click="$emit('unlink')" class="bg-red-500 text-white px-3 py-1 rounded">
            取消連結
        </button>
        <button v-else @click="$emit('link')" class="bg-green-500 text-white px-3 py-1 rounded">
            連結
        </button>
    </div>
</template>

<script>
export default {
    props: {
        provider: String,
        email: String,
        linked: Boolean
    }
}
</script>
