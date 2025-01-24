import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'selector',
    content: ['./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php', './storage/framework/views/*.php', './resources/**/*.blade.php', './resources/**/*.js', './resources/**/*.vue'],
    theme: {
        extend: {
            colors: {
                dark: '#0B0C14',
                neutral: 'rgb(100, 110, 135)',
                primary: '#FF6B00',
                secondary: 'rgb(1, 114, 173)',
                accent: '#FFAD69',
                logo: 'rgb(1, 114, 173)',
                burger: '#009dbc',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                oswald: ['Oswald', ...defaultTheme.fontFamily.sans],
                roboto: ['Roboto', ...defaultTheme.fontFamily.sans],
                condensed: ['Roboto Condensed', ...defaultTheme.fontFamily.sans],
                nav: ['Roboto Condensed', ...defaultTheme.fontFamily.sans],
                heading: ['Roboto Condensed', ...defaultTheme.fontFamily.sans],
                body: ['"Open Sans"'],
            },
            fontSize: {
                '3xs': '9px',
                '2xs': '10px',
                xs: '12px',
                sm: '14px',
                base: '16px',
                lg: '18px',
                xl: '20px',
                '2xl': '24px',
                '3xl': '30px',
                '4xl': '36px',
                '5xl': '48px',
                '6xl': '60px',
                '7xl': '72px',
            },
            spacing: {
                px: '1px',
                0: '0',
                0.5: '2px',
                1: '4px',
                1.5: '6px',
                2: '8px',
                2.5: '10px',
                3: '12px',
                3.5: '14px',
                4: '16px',
                5: '20px',
                6: '24px',
                7: '28px',
                8: '32px',
                9: '36px',
                10: '40px',
                11: '44px',
                12: '48px',
                14: '56px',
                16: '64px',
                20: '80px',
                24: '96px',
                28: '112px',
                32: '128px',
                36: '144px',
                40: '160px',
                44: '176px',
                48: '192px',
                52: '208px',
                56: '224px',
                60: '240px',
                64: '256px',
                72: '288px',
                80: '320px',
                96: '384px',
            },
        },
        screens: {
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1280px',
            '2xl': '1536px',
            '3xl': '1920px',
        },
    },
    plugins: [
        // require('tailwindcss-motion'),
        // require('../../vendor/awcodes/filament-tiptap-editor/resources/css/plugin.css'),
    ],
};
