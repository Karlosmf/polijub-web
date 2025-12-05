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
                'brand-primary': '#00aa8d',
                'brand-secondary': '#21C4A5',
                'accent-pink': '#FF007F',
                'accent-blue': '#2AB0FF',

                // New Design System Colors
                primary: {
                    DEFAULT: '#0F172A',
                    light: '#1E293B',
                    dark: '#020617',
                },
                secondary: {
                    DEFAULT: '#F59E0B',
                    light: '#FBBF24',
                    dark: '#D97706',
                },
                background: {
                    body: '#F8FAFC',
                    card: '#FFFFFF',
                    surface: '#F1F5F9',
                },
                text: {
                    main: '#334155',
                    heading: '#0F172A',
                    muted: '#64748B',
                    inverse: '#FFFFFF',
                },
                status: {
                    success: '#10B981',
                    error: '#EF4444',
                    info: '#3B82F6',
                },
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
                display: ['Montserrat', 'sans-serif'],
            },
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