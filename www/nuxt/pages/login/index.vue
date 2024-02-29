<template>
    <div class="w-screen h-screen login-bg relative">
        <div class="absolute bg-white shadow-md flex flex-col card login-card">
            <img class="self-center logo" src="../../assets/image/default/logo.png" alt="华清宫">

            <div class="login-form">
                <label class="input input-sm 2xl:input-md input-bordered rounded-full flex items-center gap-3">
                    <div>
                        <span class="text-red-600 mr-2">*</span>
                        <span>账号</span>
                    </div>
                    <input v-model="account" type="text" class="grow" placeholder="请输入账号" />
                </label>

                <label class="input input-sm 2xl:input-md input-bordered rounded-full flex items-center gap-3 mt-5">
                    <div>
                        <span class="text-red-600 mr-2">*</span>
                        <span>密码</span>
                    </div>
                    <input v-model="password" type="password" class="grow" placeholder="请输入密码" />
                </label>

                <label class="label cursor-pointer inline-flex mt-3">
                    <input type="checkbox" v-model="checked" class="checkbox checkbox-warning checkbox-sm" />
                    <span class="label-text ml-2">记住密码</span>
                </label>

                <div v-if="error" class="text-red-500 text-xs mt-3">{{ error }}</div>

                <div class="mt-8 px-8">
                    <button class="btn btn-primary text-white btn-sm 2xl:btn-md rounded-full w-full" @click="goLogin">
                        <span v-if="loading" class="loading loading-spinner"></span>
                        登录
                    </button>
                </div>
            </div>
        </div>
    </div>

    <Dialog ref="dialogRef">
        <span class="text-sm">{{ dialogContent }}</span>
    </Dialog>
</template>

<script setup lang="ts">
import Dialog from '@/components/Dialog/Dialog.vue'
import { Login } from '@/api/api'

const user = useUser()

const account = ref<string>('')
const password = ref<string>('')
const checked = ref<boolean>(true)

const loading = ref<boolean>(false)
const error = ref<string>('')

const dialogRef = ref<InstanceType<typeof Dialog>>()
const dialogContent = ref<string>('')

function goLogin() {
    if (!account.value) {
        error.value = "请输入账号"
        return
    }

    if (!password.value) {
        error.value = "请输入密码"
        return
    }

    if (loading.value) {
        return
    }
    loading.value = true

    const data = {
        account: account.value,
        password: password.value,
        rember: checked.value
    }

    Login(data).then((res: unknown) => {
        const resTemp = res as Record<string, any>
        if (resTemp && resTemp.token) {
            user.setUserInfo(resTemp)
            navigateTo('/')
        }
        loading.value = false
    }).catch(res => {
        error.value = res.message
        loading.value = false
    })
}
</script>

<style lang="scss">
$md: 1024px;
$lg: 1280px;
$xl: 1440px;
$xll: 1536px;

.login-bg {
    background-image: url("../../assets/image/default/login-bg.png");
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    min-width: 700px;
}

.login-card {
    width: 480px;
    top: 80px;
    right: 120px;
    padding: 0 60px;

    .logo {
        width: 180px;
        margin-top: 30px;
    }

    .login-form {
        margin-top: 30px;
        margin-bottom: 30px;
    }
}

@media (min-width: $md) {
    .login-card {
        width: 480px;
        top: 120px;
        right: 150px;
        padding: 0 60px;

        .logo {
            width: 180px;
            margin-top: 30px;
        }
    }
}

@media (min-width: $xl) {
    .login-card {
        width: 520px;
        top: 150px;
        right: 180px;
        padding: 0 80px;

        .logo {
            width: 200px;
            margin-top: 30px;
        }
    }
}

@media (min-width: $xll) {
    .login-card {
        width: 590px;
        top: 160px;
        right: 220px;
        padding: 0 80px;

        .logo {
            width: 250px;
            margin-top: 40px;
        }

        .login-form {
            margin-top: 40px;
        }
    }
}
</style>