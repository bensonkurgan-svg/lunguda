import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Livewire/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                // Grounded in the Lunguda Plateau: volcanic basalt, sorghum, indigo, laterite.
                basalt:   { DEFAULT: '#1c1a17', 700: '#2b2823', 600: '#3a352e' },
                millet:   { DEFAULT: '#f6f0e2', 200: '#efe7d3', 300: '#e6dabf' },
                sorghum:  { DEFAULT: '#c8821f', 600: '#a96b16', 400: '#e0a347' },
                indigo2:  { DEFAULT: '#2c3e63', 600: '#22304d', 400: '#4a6098' },
                laterite: { DEFAULT: '#a23b25', 600: '#85301d' },
                sage:     { DEFAULT: '#6b7a5a' },
            },
            fontFamily: {
                display: ['Fraunces', ...defaultTheme.fontFamily.serif],
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                mono: ['"JetBrains Mono"', ...defaultTheme.fontFamily.mono],
            },
            boxShadow: {
                soft: '0 1px 2px rgba(28,26,23,.04), 0 8px 24px rgba(28,26,23,.06)',
                lift: '0 12px 40px rgba(28,26,23,.14)',
            },
            keyframes: {
                pulsering: {
                    '0%':   { transform: 'scale(.92)', opacity: '.7' },
                    '70%':  { transform: 'scale(1.6)', opacity: '0' },
                    '100%': { transform: 'scale(1.6)', opacity: '0' },
                },
                rise: {
                    '0%':   { opacity: '0', transform: 'translateY(14px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
            animation: {
                pulsering: 'pulsering 1.8s cubic-bezier(.4,0,.2,1) infinite',
                rise: 'rise .6s cubic-bezier(.16,1,.3,1) both',
            },
        },
    },
    plugins: [forms, typography],
};
