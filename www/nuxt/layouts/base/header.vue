<template>
    <header class="w-full relative shadow-sm">
        <div class="container flex items-center h-[104px]">
            <img class="w-[211px] h-[60px] mr-10" src="../../assets/image/default/logo.png" alt="首页" />

            <span v-if="user.nickname" class="text-gray-600 text-[13px] cursor-pointer hover:text-black ml-3">{{ user.nickname }}</span>
        </div>

        <div>

        </div>
    </header>
</template>

<script setup lang="ts">
const user = useUser()

if (!user.token) {
    // navigateTo('/login')
}
</script>