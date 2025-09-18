<template>
    <section>
        <h2 class="text-lg font-semibold mb-2">帳號合併建議</h2>
        <div class="space-y-2">
            <div v-for="(account, index) in accounts" :key="index"
                class="flex items-center justify-between bg-white p-4 rounded shadow">
                <div>
                    <div class="font-medium">{{ account.email }}</div>
                </div>
                <div class="space-x-2">
                    <button class="bg-green-500 text-white px-3 py-1 rounded" @click="mergeAccount(index)">合併</button>
                    <button class="bg-gray-300 text-gray-800 px-3 py-1 rounded"
                        @click="ignoreAccount(index)">忽略</button>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            accounts: [
                { email: 'test@email.com' },
                { email: 'other@email.com' }
            ]
        }
    },
    methods: {
        mergeAccount(index) {
            console.log(`合併帳號：${this.accounts[index].email}`)
        },
        ignoreAccount(index) {
            console.log(`忽略帳號：${this.accounts[index].email}`)
        }
    }
}
</script>
