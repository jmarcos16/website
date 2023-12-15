/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#1F293B",
        secondary: "#353535",
        danger: "#e3342f",
      },
      fontFamily: {
        sans: ["Albert Sans", "sans-serif"],
      },     

    },
  },
  plugins: [],
  
}

