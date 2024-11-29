import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: ['./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php', './storage/framework/views/*.php', './resources/**/*.blade.php', './resources/**/*.js', './resources/**/*.vue'],
    theme: {
        extend: {
            colors: {
                primary: '#FF6B00',
                secondary: 'rgb(1, 114, 173)',
                accent: '#FFAD69',
                logo: 'rgb(1, 114, 173)',
                burger: '#009dbc',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                oswald: ['Oswald', ...defaultTheme.fontFamily.sans],
                nav: ['Oswald', ...defaultTheme.fontFamily.sans],
                body: ['"Open Sans"'],
            },
            fontSize: {
                '3xs': '0.5rem',
                '2xs': '0.6rem',
                xs: '0.7rem',
                sm: '0.8rem',
                base: '1rem',
                xl: '1.25rem',
                '2xl': '1.563rem',
                '3xl': '1.953rem',
                '4xl': '2.441rem',
                '5xl': '3.052rem',
            },
        },
    },
    plugins: [
        // require('../../vendor/awcodes/filament-tiptap-editor/resources/css/plugin.css'),
    ],
};
