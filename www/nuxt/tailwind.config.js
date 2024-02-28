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
      'sm': '1280px',
      'md': '1280px',
      'lg': '1440px',
      'xl': '1536px',
      '2xl': '1782px'
    },
    container: {
      center: true,
      padding: {
        'sm': '4px',
        'md': '4px',
        'lg': '4px',
        'xl': '8px',
        '2xl': '16px'
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

