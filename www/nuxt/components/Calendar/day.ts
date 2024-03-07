interface CalendarDate {
    year: number;
    month: number;
    day: number;
    week: number;
}

const weeksData = [
  {
    label: "日",
    value: 0,
  },
  {
    label: "一",
    value: 1,
  },
  {
    label: "二",
    value: 2,
  },
  {
    label: "三",
    value: 3,
  },
  {
    label: "四",
    value: 4,
  },
  {
    label: "五",
    value: 5,
  },
  {
    label: "六",
    value: 6,
  },
];

const getToday = function (value: string | null): CalendarDate {
  const date = value ? new Date(value) : new Date();

  return {
    year: date.getFullYear(),
    month: date.getMonth() + 1,
    day: date.getDate(),
    week: date.getDay(),
  };
};

const getYestoday = function (value: string | null):CalendarDate {
  const date = value ? new Date(value) : new Date();

  date.setDate(date.getDate() - 1);

  return {
    year: date.getFullYear(),
    month: date.getMonth() + 1,
    day: date.getDate(),
    week: date.getDay(),
  };
};

const getFirthDayAndLastDayOfMonth = function(year:number, month:number, day:number) {
    const firthDateOfMonth = getToday(`${year}/${month}/1`)
    const lastDateOfMonth = month === 12 ? getYestoday(`${year + 1}/1/1`) : getYestoday(`${year}/${month + 1}/1`)
    
    return {
        first: firthDateOfMonth,
        last: lastDateOfMonth
    }
}

export { weeksData, getToday, getYestoday, getFirthDayAndLastDayOfMonth };    

export type { CalendarDate };

