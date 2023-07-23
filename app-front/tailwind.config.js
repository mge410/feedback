/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./index.html",
        "./src/**/*.{vue,js,ts}",
    ],
    theme: {
        extend: {
            colors: {
                'brand-1': '#246CAB',
                'brand-2': '#50B792',
                'dark': '#191919',
                'light': '#F2F2F2',
                'light-2': '#BFBFBF',
            }
        },
    },
    plugins: [],
}

