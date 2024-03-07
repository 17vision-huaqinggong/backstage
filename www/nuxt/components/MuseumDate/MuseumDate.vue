<template>
    <div class="dropdown dropdown-bottom dropdown-end relative">
        <div v-if="hasCalendar" class="absolute top-0 left-0 w-[32px] h-[32px] calendar-btn cursor-pointer" @click="goShowCalendar"></div>

        <div v-if="hasCalendar" class="absolute top-9 right-0 w-[320px] shadow calendar-con z-50" :class="{ 'show': showCalendar }">
            <Calendar @onDateChange="onDateChange" />
        </div>

        <div tabindex="0" class="flex items-center px-3 py-[5px] mb-1 border border-stone-300 rounded cursor-pointer">
            <img v-if="hasCalendar" class="w-[15px]" src="../../assets/image/default/date.png" alt="日期">
            <span class="text-sm  text-stone-700 ml-3 mr-6">{{ dayStr }}</span>
            <img class="w-[12px] opacity-60" src="@/assets/image/default/down.png" alt="">
        </div>

        <div tabindex="0" class="dropdown-content z-[1] shadow bg-base-100 w-40 day-list">
            <div v-for="(item, index) in days" :key="index" class="day-item" :class="{ 'day-item-active': item.value === day }"
                @click="selectDay(index)">
                {{ item.label }}
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { dayData } from '@/assets/data/museum'
import { type CalendarDate } from '@/components/Calendar/day'

const emits = defineEmits(['onChangeDay'])

const day = ref<number>(0)
const days = ref(dayData)
const dayStr = ref<string>('今天')
const showCalendar = ref<boolean>(false)

interface Props {
    hasCalendar?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    hasCalendar: true,
});

function goShowCalendar() {
    showCalendar.value = !showCalendar.value
}

function selectDay(value: number) {
    if (document.activeElement instanceof HTMLElement) {
        document.activeElement.blur()
    }

    day.value = days.value[value].value
    dayStr.value = days.value[value].label

    emits('onChangeDay', { day: day.value, dayStr: dayStr.value })
}

function onDateChange(value: CalendarDate) {
    showCalendar.value = false

    const tempDay = `${value.year}-${value.month}-${value.day}`

    const tempDayStr = tempDay

    dayStr.value = tempDay

    day.value = -1

    emits('onChangeDay', { day: tempDay, dayStr: tempDayStr })
}
</script>

<style lang="scss">
.calendar-con {
    opacity: 0;
    transform: scaleY(0);
    transition: opacity 0.6s;

    &.show {
        transform: scaleY(1);
        opacity: 1;
    }
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