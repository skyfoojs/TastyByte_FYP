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
            fontFamily: {
                mont: ['Montserrat', 'sans-serif'],
                pop: ['Poppins', 'sans-serif'],
            },

            colors: {
                'blue-button' : '#3B82F6',
                'light-gray' : '#CFCFCF',
            }
        },
    },
    plugins: [],
};
