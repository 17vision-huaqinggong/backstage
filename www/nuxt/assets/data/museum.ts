const lineData = {
  tooltip: {
    trigger: "axis",
  },
  legend: {
    data: ["设备佩戴量", "设备浏览量"],
  },
  grid: {
    left: "3%",
    right: "4%",
    bottom: "3%",
    containLabel: true,
  },
  toolbox: {
    feature: {
      saveAsImage: {},
    },
  },
  xAxis: {
    type: "category",
    boundaryGap: false,
    data: [
      "09:00",
      "10:00",
      "11:00",
      "12:00",
      "13:00",
      "14:00",
      "15:00",
      "16:00",
      "17:00",
      "18:00",
    ],
  },
  yAxis: {
    type: "value",
    minInterval: 1,
    axisLabel: {
      formatter: "{value}",
    },
  },
  series: [
    {
      name: "设备佩戴量",
      type: "line",
      data: [],
      yAxisIndex: 0,
      // 线的颜色
      lineStyle: {
        color: "#38BA3B",
        width: 1,
      },
      // 点的颜色
      itemStyle: {
        color: "#38BA3B",
      },
      // 区域的颜色
    //   areaStyle: {
    //     color: {
    //       type: "linear",
    //       x: 0,
    //       y: 0,
    //       x2: 0,
    //       y2: 1,
    //       colorStops: [
    //         {
    //           offset: 0,
    //           color: "#38BA3B", // 0% 处的颜色
    //         },
    //         {
    //           offset: 1,
    //           color: "#ffffff", // 100% 处的颜色
    //         },
    //       ],
    //     },
    //   },
    },
    {
      name: "设备浏览量",
      type: "line",
      data: [],
      yAxisIndex: 0,
      // 线的颜色
      lineStyle: {
        color: "#387FBA",
        width: 1,
      },
      // 点的颜色
      itemStyle: {
        color: "#387FBA",
      },
      //   区域的颜色
    //   areaStyle: {
    //     color: {
    //       type: "linear",
    //       x: 0,
    //       y: 0,
    //       x2: 0,
    //       y2: 1,
    //       colorStops: [
    //         {
    //           offset: 0,
    //           color: "#387FBA", // 0% 处的颜色
    //         },
    //         {
    //           offset: 1,
    //           color: "#ffffff", // 100% 处的颜色
    //         },
    //       ],
    //     },
    //   },
    },
  ],
};

const dayData = [
    {
        label: '今天',
        value: 0
    },
    {
        label: '近 7 天',
        value: 7
    },
    {
        label: '近 15 天',
        value: 15
    },
    {
        label: '近 30 天',
        value: 30
    }
]

export { lineData, dayData }