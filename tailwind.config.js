import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    DEFAULT: '#1E4D9C',
                    50:  '#EFF4FB',
                    100: '#D5E2F4',
                    200: '#ACC5E9',
                    300: '#82A8DE',
                    400: '#598BD3',
                    500: '#3B82F6',
                    600: '#2563EB',
                    700: '#1E4D9C',
                    800: '#163A78',
                    900: '#0F2754',
                },
            },
        },
    },

    plugins: [forms],
};
