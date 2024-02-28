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

                <div class="mt-8 px-8">
                    <button class="btn btn-primary text-white btn-sm 2xl:btn-md rounded-full w-full" @click="goLogin">登录</button>
                </div>
            </div>
        </div>
    </div>

    <dialog id="dialog" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <p class="py-4">Press ESC key or click the button below to close</p>
        </div>
    </dialog>
    <Dialog ref="dialogRef">
        <span class="text-sm">{{ dialogContent }}</span>
    </Dialog>
</template>

<script setup lang="ts">
import Dialog from '@/components/Dialog/Dialog.vue'

const checked = ref < boolean > (true)
const account = ref < string > ('')
const password = ref < string > ('')

const dialogRef = ref<InstanceType<typeof Dialog>>()
const dialogContent = ref<string>('')

function goLogin() {
    if (!account.value) {
        dialogContent.value = "请输入账号"
        dialogRef.value?.open()
        return
    }

    if (!password.value) {
        dialogContent.value = "请输入密码"
        dialogRef.value?.open()
        return
    }

    const data = {
        account: account.value,
        password: password.value,
        rember: checked.value
    }
}
</script>

<style lang="scss">
$md: 1280px;
$lg: 1440px;
$xl: 1536px;
$xll: 1782px;

.login-bg {
    background-image: url("../../assets/image/default/login-bg.png");
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    min-width: 700px;
}

.login-card {
    width: 450px;
    top: 120px;
    right: 160px;
    padding: 0 40px;

    .logo {
        width: 200px;
        margin-top: 32px;
    }

    .login-form {
        margin-top: 30px;
        margin-bottom: 30px;
    }
}

@media (min-width: $md) {
    .login-card {
        width: 450px;
        top: 120px;
        right: 160px;
        padding: 0 40px;

        .logo {
            width: 200px;
            margin-top: 32px;
        }

        .login-form {
            margin-top: 30px;
            margin-bottom: 30px;
        }
    }
}


@media (min-width: $lg) {
    .login-card {
        width: 520px;
        top: 120px;
        right: 160px;
        padding: 0 60px;

        .logo {
            width: 250px;
            margin-top: 45px;
        }
    }
}

@media (min-width: $xl) {
    .login-card {
        width: 590px;
        top: 150px;
        right: 200px;
        padding: 0 80px;

        .logo {
            width: 300px;
            margin-top: 52px;
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
            width: 300px;
            margin-top: 52px;
        }
    }
}
</style>