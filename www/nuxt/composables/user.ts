interface UserState {
  token: string;
  id: number;
  nickname: string;
  avatar: string;
}

export const useUser = defineStore("user", {
  state: (): UserState => ({
    token: "",
    id: 0,
    nickname: "",
    avatar: "",
  }),
  actions: {},
  // 注意：persist 定义要做判断，因为 localStorage/sessionStorage 是客户端参数，所以需要加 process.client
  persist: process.client && {
    storage: sessionStorage,
  },
});
