const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
  content: [
    "./authentication/**/*.{html,php,js}",
    "./authentication/assets/**/*.{html,php,js}",
    "./admin/**/*.{html,php,js}",
    "./meter-reader/**/*.{html,php,js}",
    "./cashier/**/*.{html,php,js}",
    "./index.php",
    "./node_modules/flowbite/**/*.js",
    "./**/*.html",
    "./**/*.php",
    "./**/*.js"
  ],
  theme: {
    extend: {
      screens: {
        xs: "540px",
        ...defaultTheme.screens,
      },
      colors: {
        primary: {
          50: "#eef2ff",
          100: "#e0e7ff",
          200: "#c7d2fe",
          300: "#a5b4fc",
          400: "#818cf8",
          500: "#6366f1",
          600: "#4f46e5",
          700: "#4338ca",
          800: "#3730a3",
          900: "#312e81",
          950: "#1e1b4b",
        },
      },
      boxShadow: {
        sm: "0 1px 3px 0 rgba(15, 23, 42, 0.07), 0 1px 2px 0 rgba(15, 23, 42, 0.03)",
        md: "0 4px 6px -1px rgba(15, 23, 42, 0.07), 0 2px 4px -1px rgba(15, 23, 42, 0.03)",
        lg: "0 10px 15px -3px rgba(15, 23, 42, 0.07), 0 4px 6px -2px rgba(15, 23, 42, 0.02)",
        xl: "0 20px 25px -5px rgba(15, 23, 42, 0.07), 0 10px 10px -5px rgba(15, 23, 42, 0.02)",
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('tailwindcss-font-inter'),
    require('flowbite/plugin')
  ],
};


