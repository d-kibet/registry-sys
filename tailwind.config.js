import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/livewire/livewire/src/Features/SupportLocales/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Livewire/**/*.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Official UDA Brand Colors from uda.ke
                'uda-yellow': {
                    50: '#FFFCF0',
                    100: '#FFF8DB',
                    200: '#FFF0B8',
                    300: '#FFE894',
                    400: '#FDE070',
                    500: '#F7C821', // Official UDA Yellow
                    600: '#DEB01D',
                    700: '#B89219',
                    800: '#8F7115',
                    900: '#665011',
                },
                'uda-green': {
                    50: '#E8F7EE',
                    100: '#C5EBCF',
                    200: '#9CDEB3',
                    300: '#73D197',
                    400: '#4AC47B',
                    500: '#179847', // Official UDA Green
                    600: '#138A3E',
                    700: '#0F7335',
                    800: '#0B5C2B',
                    900: '#074521',
                },
                'uda-dark': {
                    50: '#F5F5F5',
                    100: '#E6E6E6',
                    200: '#CCCCCC',
                    300: '#B3B3B3',
                    400: '#999999',
                    500: '#191919', // Official UDA Dark
                    600: '#161616',
                    700: '#131313',
                    800: '#101010',
                    900: '#0D0D0D',
                },
            },
        },
    },
    plugins: [forms],
};
