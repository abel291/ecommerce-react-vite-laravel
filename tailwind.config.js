const defaultTheme = require('tailwindcss/defaultTheme');
/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')
module.exports = {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',

        //dashboard
        //"./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        colors: {
            ...colors,
            primary: colors.red,
        },

        container: {
            center: true,
            padding: {
                DEFAULT: "1.5rem",
                sm: "2rem",
                lg: "4rem",
                xl: "6rem",
            },
        },
        extend: {
            //accordion search filters
            transitionProperty: {
                'height': 'height',
            },
            //animation toast
            animation: {
                enter: 'enter 200ms ease-out',
                'slide-in': 'slide-in 1.2s cubic-bezier(.41,.73,.51,1.02)',
                leave: 'leave 150ms ease-in forwards',
            },
            keyframes: {
                enter: {
                    '0%': { transform: 'scale(0.9)', opacity: 0 },
                    '100%': { transform: 'scale(1)', opacity: 1 },
                },
                leave: {
                    '0%': { transform: 'scale(1)', opacity: 1 },
                    '100%': { transform: 'scale(0.9)', opacity: 0 },
                },
                'slide-in': {
                    '0%': { transform: 'translateY(-100%)' },
                    '100%': { transform: 'translateY(0)' },
                },
            }

        }
    },

    plugins: [require('@tailwindcss/forms'), require('flowbite/plugin')],




};
