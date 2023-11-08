const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'yellow': {
                  50: '#fffbeb',
                  100: '#fef3c7',
                  200: '#fde68a',
                  300: '#fcd34d',
                  400: '#fbbf24',
                  500: '#f59e0b',
                  600: '#d97706',
                  700: '#b45309',
                  800: '#92400e',
                  900: '#78350f',
                },
                'pirategold': {
                  50: '#fefce8',
                  100: '#fffac2',
                  200: '#fff388',
                  300: '#ffe443',
                  400: '#ffd010',
                  500: '#efb603',
                  600: '#bd8100',
                  700: '#a46404',
                  800: '#874e0c',
                  900: '#734010',
                },
                'ebony': {
                  50: '#f2f6fb',
                  100: '#d4e1f3',
                  200: '#a9c0e6',
                  300: '#7695d2',
                  400: '#4a6bb7',
                  500: '#30509c',
                  600: '#243c7d',
                  700: '#002952',
                  800: '#001f3d',
                  900: '#001429',
                },
              },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
