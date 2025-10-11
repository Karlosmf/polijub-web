/** @type {import('tailwindcss').Config} */
export default {
content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./resources/css/app.css",
],
theme: {
    extend: {
    colors: {
        'brand-primary': '#FF6B6B',
        'accent-pink': '#FFCOCB',
        'footer-fondo': '#333333',
    },
    fontFamily: {
        // Define una fuente personalizada si es necesario, ejemplo:
        // 'principal': ['"Nombre de la Fuente"', 'sans-serif'],
    },
    container: {
        center: true,
        padding: '1rem',
        screens: {
        sm: '640px',
        md: '768px',
        lg: '1024px',
        xl: '1200px', // layout_css.container_max_width
        },
    },
    },
},
plugins: [],
}