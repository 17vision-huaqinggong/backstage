/** @type {import('tailwindcss').Config} */
import Daisyui  from 'daisyui'

export default {
  mode: 'jit',
  content: [
    './components/**/*.{js,vue,ts}',
    './layouts/**/*.vue',
    './pages/**/*.vue',
    './plugins/**/*.{js,ts}',
    './nuxt.config.{js,ts}'
  ],
  theme: {
    screens: {
      'sm': '1024px',
      'md': '1024px',
      'lg': '1280px',
      'xl': '1440px',
      '2xl': '1536px'
    },
    container: {
      center: true,
      padding: {
        'sm': '0px',
        'md': '10px',
        'lg': '10px',
        'xl': '20px',
        '2xl': '20px'
      },
    },
  },
  plugins: [
    Daisyui,
  ],
  daisyui: {
    themes: [
      {
        mytheme: {
          "primary": "#ffa000",
          "secondary": "#f6d860",
          "accent": "#37cdbe",
          "neutral": "#3d4451",
          "base-100": "#ffffff",
        },
      }
    ]
  }
}

