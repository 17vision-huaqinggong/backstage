<template>
    <div class="flex flex-shrink-0 w-[220px] h-full bg-white rounded-lg py-5">
        <div v-for="(item, index) in navs" :key="index" class="nav-list">
            <div class="nav-item">
                <span>{{ item.label }}</span>
                <img class="w-[16px] ml-auto" src="../../assets/image/default/down.png" alt="">
            </div>

            <div v-if="item.childs?.length">
                <div v-for="(child, childIndex) in item.childs" :key="childIndex" @click="goMuseum(child.id)">
                    <div class="nav-item nav-item-sub" :class="{ 'nav-item-active': child.id === id }">
                        <span>{{ child.label }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">

import navData from '../../assets/data/nav'

const route = useRoute()

const id = ref<number>()

const navs = ref<NavItem[]>(navData.navlist)

function getFirstId() {
    if (navs.value.length > 0 && navs.value[0]['childs']?.length && navs.value[0]['childs']?.length > 0) {
        return navs.value[0]['childs'][0]['id']
    }
    return ''
}

function goMuseum(value: number) {
    id.value = value
    navigateTo('/museum?id=' + value)
}

function initialize() {
    // 博物馆路由
    if (route.path === '/museum') {
        if (!route.query.id) {
            return navigateTo('/museum?id=' + getFirstId())
        }

        if (typeof route.query.id === 'string') {
            if (navData.whiteList.indexOf(parseInt(route.query.id)) === -1) {
                return navigateTo('/museum?id=' + getFirstId())
            }
            id.value = parseInt(route.query.id)
        }
    }
}

initialize()
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