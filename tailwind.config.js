import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#FF6B00', // Vibrant orange like a basketball
                secondary: '#47A8BD', // Deep navy blue like classic sports jerseys
                accent: '#FFAD69', // Clean white/grey like court lines
                'burger-weekend': '#009dbc',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                oswald: ['Oswald', ...defaultTheme.fontFamily.sans],
                nav: ['Oswald', ...defaultTheme.fontFamily.sans],
                body: ['"Open Sans"'],
            },
        },
    },
    plugins: [
        //
    ],

};
