/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme';
import config from './theme.config.json';

export default {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Quicksand"', ...defaultTheme.fontFamily.sans],
            },
            colors: config.colors,
        },
    },
    plugins: [],
};
