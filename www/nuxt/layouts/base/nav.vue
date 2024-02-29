<template>
    <div class="flex w-[220px] h-full bg-white rounded-lg py-5">
        <div v-for="(item, index) in navs" :key="index" class="nav-list">
            <div class="nav-item">
                <span>{{ item.label }}</span>
                <img class="w-[16px] ml-auto" src="../../assets/image/default/down.png" alt="">
            </div>

            <div v-if="item.childs?.length">
                <div v-for="(child, childIndex) in item.childs" :key="childIndex">
                    <div class="nav-item nav-item-sub" :class="{'nav-item-active': childIndex === 0}">
                        <span>{{ child.label }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">

interface NavItem {
    label: string
    path: string
    childs?: NavItem[]
}

const navs = ref<NavItem[]>([
    {
        label: '展馆列表',
        path: '/',
        childs: [
            {
                label: '长恨歌艺术馆',
                path: 'changhenge'
            },
            {
                label: '珍宝馆',
                path: ''
            },
            {
                label: '海棠馆',
                path: ''
            },
            {
                label: '莲花汤',
                path: ''
            },
            {
                label: '梨园博物馆',
                path: ''
            },
            {
                label: '按歌台',
                path: ''
            }
        ]
    }
])
</script>


<style lang="scss">
.nav-list {
    width: 100%;
    height: 100%;

    .nav-item {
        display: flex;
        align-items: center;
        width: 100%;
        height: 50px;
        padding: 0 20px;
        font-size: 16px;
        cursor: pointer;
        font-weight: 600;
        border-bottom: 1px solid #dedede;

        &.nav-item-sub {
            justify-content: center;
            height: 48px;
            padding: 0 30px;
            font-size: 14px;
            font-weight: 400;
            transition: background-color 0.5s, color 0.4s;
            border-bottom: none;

            span {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
                height: 100%;
                border-bottom: 1px solid #dedede;
            }
        }

        &.nav-item-active {
            background-color: #FFF5E5;
            color: #FDA51B;
            font-weight: 600;
        }

        &.nav-item-sub:hover {
            background-color: #FFF5E5;
            color: #FDA51B;
            font-weight: 600;
        }
    }
}
</style>