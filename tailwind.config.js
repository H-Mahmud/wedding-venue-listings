/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './templates/**/*.php',  // All PHP files inside templates
    './includes/**/*.php',   // All PHP files inside includes
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
