<template>
    <section>
        <h2 class="text-lg font-semibold mb-2">第三方帳號連結</h2>
        <div class="space-y-2">
            <AccountItem v-for="(account, index) in accounts" :key="index" :provider="account.provider"
                :email="account.email" :linked="account.linked" @link="linkAccount(account.provider)"
                @unlink="unlinkAccount(account.provider)" />
        </div>
    </section>
</template>

<script>
import AccountItem from './AccountItem.vue'

export default {
    components: { AccountItem },
    data() {
        return {
            accounts: [
                { provider: 'Apple', email: 'apple@email.com', linked: true },
                { provider: 'Google', email: 'google@email.com', linked: true },
                { provider: 'Line', email: 'line@email.com', linked: true },
                { provider: 'Facebook', email: 'facebook@email.com', linked: true }
            ]
        }
    },
    methods: {
        linkAccount(provider) {
            console.log(`綁定${provider}帳號`)
        },
        unlinkAccount(provider) {
            console.log(`解除綁定${provider}帳號`)
        }
    }
}
</script>
