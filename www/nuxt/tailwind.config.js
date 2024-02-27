/** @type {import('tailwindcss').Config} */
import Daisyui  from 'daisyui'

export default {
  content: [
    './components/**/*.{js,vue,ts}',
    './layouts/**/*.vue',
    './pages/**/*.vue',
    './plugins/**/*.{js,ts}',
    './nuxt.config.{js,ts}'
  ],
  theme: {
    extend: {},
  },
  plugins: [
    Daisyui,
  ],
  daisyui: {
    themes: ['light', 'dark']
  }
}

