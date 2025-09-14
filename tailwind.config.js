/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#2563EB', // Blue-600
          dark: '#1E40AF',    // Blue-700
          light: '#DBEAFE',   // Blue-50
        },
        secondary: {
          DEFAULT: '#9333EA', // Indigo-600
          dark: '#7E22CE',    // Indigo-700
          light: '#F3E8FF',   // Indigo-50
        },
        accent: {
          DEFAULT: '#F43F5E', // Rose-500
          dark: '#BE123C',    // Rose-600
          light: '#FFE4E6',   // Rose-50
        },
        surface: '#FFFFFF',
        'bg-light': '#F9FAFB', // Gray-50
        border: '#E5E7EB',     // Gray-200
        text: {
          DEFAULT: '#111827',  // Gray-900
          muted: '#6B7280',    // Gray-500
        },
      },
      fontFamily: {
        sans: [
          'Inter', // 👈 Recommended modern sans-serif (free & web-safe)
          'ui-sans-serif',
          'system-ui',
          '-apple-system',
          'BlinkMacSystemFont',
          'Segoe UI',
          'Roboto',
          'Helvetica Neue',
          'Arial',
          'sans-serif',
        ],
      },
      fontSize: {
        xs: ['0.75rem', { lineHeight: '1rem' }], // 12px
        sm: ['0.875rem', { lineHeight: '1.25rem' }], // 14px
        base: ['1rem', { lineHeight: '1.5rem' }], // 16px
        lg: ['1.125rem', { lineHeight: '1.75rem' }], // 18px
        xl: ['1.25rem', { lineHeight: '1.75rem' }], // 20px
        '2xl': ['1.5rem', { lineHeight: '2rem' }], // 24px
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }], // 30px
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }], // 36px
      },
      borderRadius: {
        DEFAULT: '0.375rem', // 6px
        none: '0',
        sm: '0.125rem', // 2px
        lg: '0.5rem', // 8px
        full: '9999px',
      },
      spacing: {
        0.5: '0.125rem',
        1.5: '0.375rem',
        7: '1.75rem',
        8.5: '2.125rem',
        11: '2.75rem',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'), // 👈 Highly recommended for clean prose
    require('@tailwindcss/aspect-ratio'), // Optional but useful for media
  ],
};