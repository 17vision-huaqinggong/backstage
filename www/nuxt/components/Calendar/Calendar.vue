<template>
    <div class="calendar-container">
        <header>
            <div class="arrow-svg prev-arrow" @click="goPrevMonth">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M15.4,9.88,10.81,5.29a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42L14,11.29a1,1,0,0,1,0,1.42L9.4,17.29a1,1,0,0,0,1.41,1.42l4.59-4.59A3,3,0,0,0,15.4,9.88Z" />
                </svg>
            </div>
            <div class="title">{{ `${year}年${month}月` }}</div>

            <div class="arrow-svg next-arrow" @click="goNextMonth">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M15.4,9.88,10.81,5.29a1,1,0,0,0-1.41,0,1,1,0,0,0,0,1.42L14,11.29a1,1,0,0,1,0,1.42L9.4,17.29a1,1,0,0,0,1.41,1.42l4.59-4.59A3,3,0,0,0,15.4,9.88Z" />
                </svg>
            </div>
        </header>

        <body>
            <div class="week">
                <span v-for="(item, index) in weeksData" :key="index">{{ item.label }}</span>
            </div>

            <div v-for="(lineItem, lineIndex) in calendarData" :key="lineIndex" class="line-list">
                <div v-for="(dayItem, dayIndex) in lineItem" :key="dayIndex" class="line-item">
                    <div class="day-item"
                        :class="{ 'other-month-item': dayItem.monthType !== MonthType.Cur, 'active-item': dayItem.active, 'cur-day-item': isToday(dayItem) }"
                        @click="selectDay(dayItem)">
                        {{ dayItem.day }}
                    </div>
                </div>
            </div>
        </body>

        <footer>
            <div class="button" @click="goToday">今天</div>
            <div class="button" @click="goSubmit">确定</div>
        </footer>
    </div>
</template>

<script setup lang="ts">
import { weeksData, getToday, type CalendarDate, getFirthDayAndLastDayOfMonth } from './day'

enum MonthType {
    Prev = 1,
    Cur = 2,
    Next = 3
}

interface DayItem extends CalendarDate {
    monthType: MonthType,
    active?: boolean
}

interface Emits {
  (e: "onDateChange", value: CalendarDate): void;
}

const emits = defineEmits(['onDateChange'])

// 今天
let today: CalendarDate;

const year = ref<number>(2024)
const month = ref<number>(1)
const day = ref<number>(1)
const week = ref<number>(1)

const calendarData = ref<DayItem[][]>()

onBeforeMount(() => {
    today = getToday(null)

    year.value = today.year
    month.value = today.month
    day.value = today.day
    week.value = today.week

    initialize()
})

function initialize() {
    calendarData.value = getCalendarData(year.value, month.value, day.value)
}

function getCalendarData(y: number, m: number, d: number): DayItem[][] {
    const prevMonth = m === 1 ? getFirthDayAndLastDayOfMonth(y - 1, 12, 1) : getFirthDayAndLastDayOfMonth(y, m - 1, 1)
    const curMonth = getFirthDayAndLastDayOfMonth(y, m, d)
    const nextMonth = m === 12 ? getFirthDayAndLastDayOfMonth(y + 1, 1, 1) : getFirthDayAndLastDayOfMonth(y, m + 1, 1)
    const data: DayItem[][] = [];
    const lineDayItems: DayItem[] = []

    // 先把第一行搞出来了
    let tempDay = 0
    weeksData.forEach((item, index) => {
        // 如果星期小于当前月第一天的星期，就补上个月的
        if (item.value < curMonth.first.week) {
            lineDayItems.push({
                year: prevMonth.last.year,
                month: prevMonth.last.month,
                day: prevMonth.last.day - item.value,
                week: index,
                monthType: MonthType.Prev
            })
        } else {
            // 特殊时刻处理
            tempDay = tempDay === 0 && lineDayItems.reverse() ? 1 : tempDay

            lineDayItems.push({
                year: curMonth.last.year,
                month: curMonth.last.month,
                day: tempDay,
                week: index,
                monthType: MonthType.Cur
            })
            tempDay++
        }
    })
    data.push(lineDayItems.concat())

    // 再搞后边的，凑齐整行
    const len = (7 - (curMonth.last.day - tempDay + 1) % 7) + curMonth.last.day - tempDay + 1
    console.log('len = ', len, curMonth.last.day, tempDay)
    for (let i = 0; i < len; i++) {
        if (i % 7 === 0) {
            lineDayItems.splice(0, lineDayItems.length)
        }

        // 特殊时刻
        tempDay = tempDay > curMonth.last.day ? 1 : tempDay

        // 如果不是第一行，且日期小于 7，肯定是下个月的
        let isNextMonth = i > 6 && tempDay < 7 ? true : false

        lineDayItems.push({
            year: isNextMonth ? nextMonth.first.year : curMonth.last.year,
            month: isNextMonth ? nextMonth.first.month : curMonth.last.month,
            day: tempDay,
            week: i % 7,
            monthType: isNextMonth ? MonthType.Next : MonthType.Cur
        })

        // 每行最后一个搞完，就塞到数据里
        if (i % 7 === 6) {
            data.push(lineDayItems.concat())
        }

        tempDay++
    }

    // 如果日历只有 5 行的话，把它凑到 6 行
    if (data.length < 6) {
        lineDayItems.splice(0, lineDayItems.length)
        weeksData.forEach((item, index) => {
            lineDayItems.push({
                year: nextMonth.first.year,
                month: nextMonth.first.month,
                day: tempDay,
                week: index,
                monthType: MonthType.Next
            })
            tempDay++
        })
        data.push(lineDayItems.concat())
    }
    return data
}

function isToday(value: DayItem): boolean {
    if (today && today.day === value.day && today.month === value.month && today.year === value.year) {
        return true
    }
    return false
}

function goPrevMonth() {
    if (month.value === 1) {
        month.value = 12
        year.value--
    } else {
        month.value--
    }

    initialize()
}

function goNextMonth() {
    if (month.value === 12) {
        month.value = 1
        year.value++
    } else {
        month.value++
    }

    initialize()
}

function goToday() {
    year.value = today.year
    month.value = today.month
    day.value = today.day
    week.value = today.week

    initialize()

    // 激活今天
    calendarData.value?.forEach((list) => {
        list.forEach((item) => {
            if (item.day === day.value && item.month === month.value && item.day === day.value) {
                item.active = true
            } else {
                item.active = false
            }
        })
    })
}

function selectDay(value: DayItem) {
    calendarData.value?.forEach((list) => {
        list.forEach((item) => {
            item.active = false
        })
    })

    value.active = true

    year.value = value.year
    month.value = value.month
    day.value = value.day
    week.value = value.week
}

function goSubmit() {
    const value:CalendarDate = {
        year: year.value,
        month: month.value,
        day: day.value,
        week: week.value
    }

    emits('onDateChange', value)
}
</script>

<style lang="scss" scoped>
.calendar-container {
    border-radius: 8px;
    background-color: #fff;

    header {
        display: flex;
        align-items: center;
        width: 100%;
        height: 38px;
        border-bottom: 1px solid #0000000f;

        .arrow-svg {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 32px;
            height: 32px;
            cursor: pointer;

            svg {
                width: 24px;
                height: 24px;

                path {
                    fill: #0106218C;
                }
            }

            &.prev-arrow {
                transform: scaleX(-1);
            }
        }

        .arrow-svg:hover {
            opacity: 0.6;
        }

        .title {
            color: #000;
            font-size: 15px;
            font-weight: 600;
            margin: 0 auto;
        }
    }

    footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 6px 20px;
        border-top: 1px solid #0000000f;

        .button {
            font-size: 14px;
            padding: 4px 16px;
            border-radius: 20px;
            cursor: pointer;
        }

        .button:hover {
            opacity: 0.6;
        }

        .button:first-child {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .button:last-child {
            color: #ffffff;
            background-color: #5B93FF;
        }
    }

    body {
        display: flex;
        flex-direction: column;
        padding: 5px 0;

        .week {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 100%;
            height: 32px;
            color: #5B93FF;
            font-size: 14px;
        }

        .line-list {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 100%;
            height: 32px;
            font-size: 12px;

            .line-item {
                display: flex;
                width: 100%;
                height: 100%;
                padding: 3px 5px;

                .day-item {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    width: 100%;
                    height: 100%;
                    color: #000000D9;
                    cursor: pointer;
                    border-radius: 4px;

                    &.other-month-item {
                        color: #00000075;
                    }

                    &.active-item {
                        color: #fff;
                        font-size: 14px;
                        font-weight: 600;
                        background-color: #5B93FFFF;
                    }

                    &.cur-day-item {
                        color: #FFA000FF;
                    }
                }
            }
        }
    }
}
</style>