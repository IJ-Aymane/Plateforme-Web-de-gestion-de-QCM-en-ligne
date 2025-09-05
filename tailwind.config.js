/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#2563EB',
          dark: '#1E40AF',
          light: '#DBEAFE',
        },
        secondary: {
          DEFAULT: '#9333EA',
          dark: '#7E22CE',
          light: '#F3E8FF',
        },
        accent: {
          DEFAULT: '#F43F5E',
          dark: '#BE123C',
          light: '#FFE4E6',
        },
        surface: '#FFFFFF',
        'bg-light': '#F9FAFB',
        border: '#E5E7EB',
        text: {
          DEFAULT: '#111827',
          muted: '#6B7280',
        },
      },
      fontFamily: {
        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui'],
      },
    },
  },
  plugins: [require('@tailwindcss/forms')],
};