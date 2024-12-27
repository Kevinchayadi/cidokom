/** @type {import('tailwindcss').Config} */
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontSize: {
        'xxs' : '0.5rem',
        'table' : '0.7rem',
      },
      colors: {
        'primary': {
          'DEFAULT': '#b3b500',
          'dark': '#003e00',
          'dark-two':'#003700',
          'background': '#fafcfa',
          'accent': '#85b474',
          'aHover': '#6a905d',
          'bg':'#b3b500',
          'text-dark': '#001100',
          'text-dark-hover': '#222722',
          'text-light': '#ffffff',
          'text-light-hover': '#999999',
        },
      },
    },
  },
  plugins: [],
}
