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
      },
      colors: {
        'primary': {
          'DEFAULT': '#004d00',
          'background': '#fafcfa',
          'accent': '#85b474',
          'aHover': '#9EC988',
          'text': '##001100',
        }
      },
    },
  },
  plugins: [],
}
