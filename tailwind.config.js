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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['"Segoe UI"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                border: '#e4e4e7', // zinc-200
                input: '#e4e4e7', // zinc-200
                ring: '#18181b', // zinc-900
                background: '#ffffff',
                foreground: '#09090b', // zinc-950
                primary: {
                    DEFAULT: '#18181b', // zinc-900
                    foreground: '#ffffff',
                },
                secondary: {
                    DEFAULT: '#f4f4f5', // zinc-100
                    foreground: '#18181b', // zinc-900
                },
                muted: {
                    DEFAULT: '#f4f4f5', // zinc-100
                    foreground: '#71717a', // zinc-400
                },
                accent: {
                    DEFAULT: '#f4f4f5', // zinc-100
                    foreground: '#18181b', // zinc-900
                },
                destructive: {
                    DEFAULT: '#ef4444', // red-500
                    foreground: '#fafafa',
                },
            },
            borderRadius: {
                lg: `var(--radius)`,
                md: `calc(var(--radius) - 2px)`,
                sm: `calc(var(--radius) - 4px)`,
            },
        },
    },

    plugins: [forms],
};
