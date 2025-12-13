import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                primary: "#f9f506",
                "background-light": "#f8f8f5",
                "background-dark": "#23220f",
                "surface-light": "#ffffff",
                "surface-dark": "#2f2e16",
                "border-light": "#e6e6db",
                "border-dark": "#4a4825",
            },
            fontFamily: {
                display: ["Spline Sans", "sans-serif"],
                body: ["Noto Sans", "sans-serif"],
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
