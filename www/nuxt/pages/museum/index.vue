<template>
    <NuxtLayout name="base">
        <div class="px-5 py-5 container">
            <!-- 总量统计 -->
            <div class="flex justify-between">
                <span class="title-color text-base font-semibold">总量统计</span>

                <client-only>
                    <MuseumDate :hasCalendar="false" @on-change-day="onChangeTotalDay" />
                </client-only>
            </div>

            <div class="flex flex-col md:flex-row mt-3">
                <div class="flex justify-between w-[350px] h-[150px] border px-5 rounded-md mr-4"
                    style="background-color: #F2FFEDFF;border-color: #4BAF5073;">
                    <div class="flex flex-col mt-5">
                        <span style="font-size: 14px; color: #38BA3B;">{{ totalDayStr }} 佩戴量</span>
                        <span class="mt-1" style="font-size: 44px; color: #039B14;">{{ deviceBase.wears_count }}</span>
                    </div>

                    <img class="w-[118px] h-[105px] self-center" src="../../assets/image/museum/peidai.png" slot="佩戴量" />
                </div>

                <div class="flex mt-4 md:mt-0 justify-between w-[350px] h-[150px] border px-5 rounded-md"
                    style="background-color:#EDF4FFFF;border-color:#4B65AF73;">
                    <div class="flex flex-col mt-5">
                        <span style="font-size: 14px; color: #387FBA;">{{ totalDayStr }} 浏览量</span>
                        <span class="mt-1" style="font-size: 44px; color: #035B9B;">{{ deviceBase.visits_count }}</span>
                    </div>

                    <img class="w-[112px] h-[107px] self-center" src="../../assets/image/museum/liulan.png" slot="佩戴量" />
                </div>
            </div>

            <!-- 用户增长趋势 -->
            <div class="flex justify-between mt-8">
                <span class="title-color text-base font-semibold">用户增长趋势</span>

                <client-only>
                    <MuseumDate @on-change-day="onChangeListDay" />
                </client-only>
            </div>

            <client-only>
                <v-chart class="chart mt-5" ref="chartRef" :option="option" />
            </client-only>
        </div>
    </NuxtLayout>
</template>

<script setup lang="ts">
import VChart, { THEME_KEY } from 'vue-echarts';
import { use } from 'echarts/core';
import { LineChart } from 'echarts/charts';
import { GetDeciveBase, GetDeciveDetail } from '@/api/api'
import { lineData } from '@/assets/data/museum'

use([
    LineChart
]);

interface DeviceBase {
    wears_count: number
    visits_count: number
}

const deviceBase = ref<DeviceBase>({
    wears_count: 0,
    visits_count: 0
})

const route = useRoute()

const chartRef = ref<InstanceType<typeof VChart> | null>(null)
const option = ref(lineData);

let scene_id: number = 0

let totalDay: number = 0
let totalLoading: boolean = false
const totalDayStr = ref<string>('今天')

let listDay: number | string = 0
let listLoading: boolean = false

onMounted(() => {
    window.addEventListener('resize', resizeHandler)
})

onUnmounted(() => {
    window.removeEventListener('resize', resizeHandler)
})

function resizeHandler() {
    chartRef.value?.resize()
}

watch(() => route.fullPath, (value: string) => {
    console.log('vvv', value)
    console.log(route.query.id, typeof route.query.id)
    if (route.query.id && typeof route.query.id === 'string') {
        scene_id = parseInt(route.query.id)

        getDeciveBase()

        getDeciveDetail()
    }
}, {
    immediate: true
})

function onChangeTotalDay(value: any) {
    totalDay = value.day
    totalDayStr.value = value.dayStr

    getDeciveBase()
}

function onChangeListDay(value: any) {
    listDay = value.day

    getDeciveDetail()
}

function getDeciveBase() {
    if (totalLoading) {
        return
    }
    totalLoading = true

    GetDeciveBase({
        scene_id: scene_id,
        days: totalDay
    }).then((res: any) => {
        deviceBase.value.wears_count = res.wears_count
        deviceBase.value.visits_count = res.visits_count
        totalLoading = false
    }).catch(() => {
        totalLoading = false
    })
}

function getDeciveDetail() {
    if (listLoading) {
        return
    }
    listLoading = true

    GetDeciveDetail({
        scene_id: scene_id,
        days: listDay
    }).then((res: any) => {
        option.value.series[0].data = res.wears
        option.value.series[1].data = res.visits
        listLoading = false
    }).catch(() => {
        listLoading = false
    })
}
</script>

<style lang="scss" scoped>
.title-color {
    color: #000000D9;
}

.title-color-1 {
    color: #00000073;
}

.chart {
    height: 450px;
}
</style>
