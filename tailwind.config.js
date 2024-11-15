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
                primary: '#FF6B00',
                secondary: '#009dbc',
                accent: '#FFAD69',
                logo: '#009dbc',
                burger: '#009dbc',
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
        // require('../../vendor/awcodes/filament-tiptap-editor/resources/css/plugin.css'),
    ],

};
