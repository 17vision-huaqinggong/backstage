<template>
    <NuxtLayout name="base">
        <div class="px-5 py-5 container">
            <!-- 总量统计 -->
            <div class="flex justify-between">
                <span class="title-color text-base font-semibold">总量统计</span>

                <div class="dropdown dropdown-bottom dropdown-end">
                    <div tabindex="0" class="flex items-center px-3 py-[5px] mb-1 border border-stone-300 rounded cursor-pointer">
                        <img class="w-[15px]" src="../../assets/image/default/date.png" alt="日期">
                        <span class="text-sm  text-stone-700 ml-2 mr-6">{{ dayStr }}</span>
                        <img class="w-[12px] opacity-60" src="../../assets/image/default/down.png" alt="">
                    </div>

                    <div tabindex="0" class="dropdown-content z-[1] shadow bg-base-100 w-40 day-list">
                        <div v-for="(item, index) in days" :key="index" class="day-item" :class="{ 'day-item-active': item.active }"
                            @click="selectBaseDay(index)">
                            {{ item.label }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex">
                <div class="flex justify-between w-[350px] h-[150px] px-5 rounded-md mr-4" style="background-color: #4BAF5045">
                    <div class="flex flex-col mt-5">
                        <span style="font-size: 14px; color: #38BA3B;">{{ dayStr }} 佩戴量</span>
                        <span class="mt-1" style="font-size: 44px; color: #039B14;">{{ deviceBase.wears_count }}</span>
                    </div>

                    <img class="w-[118px] h-[105px] self-center" src="../../assets/image/museum/peidai.png" slot="佩戴量" />
                </div>

                <div class="flex justify-between w-[350px] h-[150px] px-5 rounded-md" style="background-color: #4B65AF45">
                    <div class="flex flex-col mt-5">
                        <span style="font-size: 14px; color: #387FBA;">{{ dayStr }} 浏览量</span>
                        <span class="mt-1" style="font-size: 44px; color: #035B9B;">{{ deviceBase.visits_count }}</span>
                    </div>

                    <img class="w-[112px] h-[107px] self-center" src="../../assets/image/museum/liulan.png" slot="佩戴量" />
                </div>
            </div>

            <!-- 用户增长趋势 -->
            <div class="title-color text-base font-semibold mt-8">用户增长趋势</div>

            <div class="flex justify-between items-center mt-2">
                <div class="divide-x divide-gray-400 divide-dashed">
                    <span class="text-sm title-color pr-3 cursor-pointer">设备佩戴量</span>
                    <span class="text-sm title-color-1 pl-3 cursor-pointer hover:opacity-60">设备浏览量</span>
                </div>
            </div>
        </div>
    </NuxtLayout>
</template>

<script setup lang="ts">

import { GetDeciveBase, GetDeciveDetail } from '@/api/api'

interface DeviceBase {
    wears_count: number
    visits_count: number
}

const deviceBase = ref<DeviceBase>({
    wears_count: 0,
    visits_count: 0
})

const route = useRoute()

let loading: boolean = false
let day: number = 0
let scene_id: number = 0

const days = ref([
    {
        label: '今天',
        value: 0,
        active: true
    },
    {
        label: '近 7 天',
        value: 7,
        active: false
    },
    {
        label: '近 15 天',
        value: 15,
        active: false
    },
    {
        label: '近 30 天',
        value: 30,
        active: false
    }
])

const dayStr = ref<string>('今天')

watch(() => route.fullPath, (value: string) => {
    console.log('vvv', value)
    console.log(route.query.id, typeof route.query.id)
    if (route.query.id && typeof route.query.id === 'string') {
        scene_id = parseInt(route.query.id)

        getDeciveBase()
    }
}, {
    immediate: true
})

function selectBaseDay(value: number) {
    days.value.forEach((item, _) => {
        item.active = false
    })

    day = days.value[value].value
    days.value[value].active = true

    dayStr.value = days.value[value].label

    getDeciveBase()
}

function getDeciveBase() {
    if (loading) {
        return
    }
    loading = true

    GetDeciveBase({
        scene_id: scene_id,
        days: day
    }).then((res: any) => {
        deviceBase.value.wears_count = res.wears_count
        deviceBase.value.visits_count = res.visits_count
        loading = false
    }).catch(() => {
        loading = false
    })
}


function getDeciveDetail() {
    GetDeciveDetail({});
}

</script>

<style lang="scss" scoped>
.title-color {
    color: #000000D9;
}

.title-color-1 {
    color: #00000073;
}

.day-list {
    border-radius: 4px;

    .day-item {
        display: flex;
        align-items: center;
        width: 100%;
        height: 40px;
        padding: 0 20px;
        font-size: 13px;
        cursor: pointer;

        &.day-item-active {
            background-color: #2750A012;
            color: #FDA51B;
        }
    }

    .day-item:hover {
        background-color: #2750A012;
        color: #FDA51B;
    }
}
</style>
