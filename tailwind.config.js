/** @type {import('tailwindcss').Config} */
export default {
    // Indique à Tailwind où chercher les classes qu'il doit générer.
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],

    theme: {
        extend: {
            // Définition de votre palette de couleurs personnalisée.
            colors: {
                primary: {
                    DEFAULT: '#005A9C', // Bleu institutionnel
                    light: '#e6f0f7',
                    dark: '#004a80',
                },
                secondary: {
                    DEFAULT: '#34495e', // Gris-bleu foncé
                },
                surface: '#ffffff', // Fond des cartes
                'bg-light': '#f8f9fa', // Fond de la page
                border: '#dee2e6',
                text: {
                    DEFAULT: '#212529', // Texte principal
                    muted: '#6c757d', // Texte secondaire
                },
            },
            // Ajout de votre police personnalisée.
            fontFamily: {
                sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui'],
            },
        },
    },

    // Plugin pour styliser les formulaires simplement.
    plugins: [require('@tailwindcss/forms')],
};