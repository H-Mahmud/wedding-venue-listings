/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './templates/**/*.php',
    './includes/**/*.php',
    './template-parts/**/*.php',
    './shortcodes/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#06070a',
        secondary: '#848484',
        tertiary: '#F2F2F2',
        quaternary: '#D9D9D9',
      },
    },
  },
  plugins: [],
}
