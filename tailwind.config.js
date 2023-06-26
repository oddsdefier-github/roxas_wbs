const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
  mode: "jit",
  content: [
    "./src/**/*.{html,php,js}",
    "./src/index.php"
  ],
  theme: {
    screens: {
      xs: "540px",
      ...defaultTheme.screens,
    },
    extend: {
      colors: {
        gray: {
          50: "#f8fafc",
          100: "#f1f5f9",
          200: "#e2e8f0",
          300: "#cbd5e1",
          400: "#94a3b8",
          500: "#64748b",
          600: "#475569",
          700: "#334155",
          800: "#1e293b",
          900: "#0f172a",
        },
        primary: {
          50: "#5f6bef",
          100: "#4f58c8",
          600: "#3a4194",
        }
      },
      boxShadow: {
        sm: "0 1px 3px 0 rgba(15,23,42,0.07), 0 1px 2px 0 rgba(15,23,42,0.03)",
        md: "0 4px 6px -1px rgba(15,23,42,0.07), 0 2px 4px -1px rgba(15,23,42,0.03)",
        lg: "0 10px 15px -3px rgba(15,23,42,0.07), 0 4px 6px -2px rgba(15,23,42,0.02)",
        xl: "0 20px 25px -5px rgba(15,23,42,0.07), 0 10px 10px -5px rgba(15,23,42,0.02)",
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('tailwindcss-font-inter')
  ],
}

