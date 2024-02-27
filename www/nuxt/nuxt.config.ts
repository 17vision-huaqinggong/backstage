// https://nuxt.com/docs/api/configuration/nuxt-config
import postcss from './postcss.config'

export default defineNuxtConfig({
  devtools: { enabled: false },
  css: [
    '@/assets/css/main.scss'
  ],
  postcss,
})
