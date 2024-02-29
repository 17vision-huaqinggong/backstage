// https://nuxt.com/docs/api/configuration/nuxt-config
import postcss from "./postcss.config";

export default defineNuxtConfig({
  typescript: {
    strict: true,
  },
  devtools: { enabled: false },
  modules: ["@pinia/nuxt", "@pinia-plugin-persistedstate/nuxt"],
  css: ["@/assets/css/main.scss"],
  postcss,
});
