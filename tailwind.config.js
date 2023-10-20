/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme';
import colors from './theme.config.js'

export default {
    // darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Quicksand"', ...defaultTheme.fontFamily.sans],
            },
            colors,
        },
    },
    plugins: [],
}

