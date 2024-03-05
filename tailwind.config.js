/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx,vue}",
  ],
  theme: {
    extend: {
      colors: {
        "ui-background": "#09090B",
        "ui-ring": "#27272A",
        "ui-primary": "#818CF8",
        "ui-card": "#18181b",
      },
      aspectRatio: {
        '3/2': '3 / 2'
      }
    },
  },
  plugins: [],
}