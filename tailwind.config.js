const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "dark-void": "#141618",
                "facebook-brand": " #3b5998",
                "twitter-brand": "#00acee",
                "instragram-brand": "#E1306C",
                "youtube-brand": "#c4302b",
            },
            height: {
                128: "32rem",
                120: "28rem",
            },
            width: {
                85: "22rem",
            },
        },
    },

    plugins: [require("@tailwindcss/forms"), require('@tailwindcss/typography'), require("flowbite/plugin")],
};
