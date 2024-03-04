interface Navs {
  whiteList: number[];
  navlist: NavItem[];
}

const navs: Navs = {
  whiteList: [1, 2, 3, 4, 5, 6],
  navlist: [
    {
      label: "展馆列表",
      id: 0,
      childs: [
        {
          label: "长恨歌艺术馆",
          id: 1,
        },
        {
          label: "珍宝馆",
          id: 2,
        },
        {
          label: "海棠馆",
          id: 3,
        },
        {
          label: "莲花汤",
          id: 4,
        },
        {
          label: "梨园博物馆",
          id: 5,
        },
        {
          label: "按歌台",
          id: 6,
        },
      ],
    },
  ],
};

export default navs;
