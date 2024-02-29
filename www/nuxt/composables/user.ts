import { defineStore } from "pinia";

interface UserState {
  token: string;
  id: number;
  nickname: string;
  avatar: string;
}

export const useUser = defineStore("user", {
  state: (): UserState => {
    return {
      token: "",
      id: 0,
      nickname: "",
      avatar: "",
    };
  },
  actions: {
    setUserInfo(value: Record<string, any>) {
      const keys: Array<string> = ["id", "nickname", "avatar", "token"];
      keys.forEach((key) => {
        if (Object.prototype.hasOwnProperty.call(value, key)) {
          this.$patch({ [key]: value[key] });
        }
      });
    },
    exit() {
      this.$patch({
        token: "",
        id: 0,
        nickname: "",
        avatar: "",
      });
    },
  },
  persist: true,
});
