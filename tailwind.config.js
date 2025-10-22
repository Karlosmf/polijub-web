/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
    ],
    theme: {
        extend: {
            colors: {
                'brand-primary': '#3E9B8A',
                'brand-secondary': '#21C4A5',
                'accent-pink': '#FF007F',
                'accent-blue': '#2AB0FF',
            }
        },
    },
    plugins: [
        require("daisyui")
    ],
    // daisyUI config (optional)
    daisyui: {
        themes: ["light", "dark"],
    },
}