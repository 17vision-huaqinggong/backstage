<template>
    <header class="w-full shadow-sm sticky top-0 bg-white/80 backdrop-blur">
        <div class="container flex items-center h-[72px]">
            <NuxtLink to="/">
                <img class="w-[128px] mr-10 cursor-pointer" src="../../assets/image/default/logo.png" alt="首页" />
            </NuxtLink>

            <div class="flex items-center ml-auto">
                <span v-if="user.nickname" class="text-gray-600 text-[15px] cursor-pointer font-semibold hover:text-black ml-3">{{ user.nickname }}</span>

                <div class="w-[32px] h-[18px] ml-3 border-l-2 border-dotted cursor-pointer flex justify-end items-center card-exit">
                    <img class="w-[18px] hover:opacity-60" src="../../assets/image/default/exit.png" alt="退出" @click="goExit" />
                </div>
            </div>
        </div>
    </header>
</template>

<script setup lang="ts">
const user = useUser()

function goExit() {
    user.exit()

    navigateTo('/login')
}
</script>