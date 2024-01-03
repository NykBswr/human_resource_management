/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#FFFDFA",
                dark: "#0b0b0b",
                secondary: "#131415",
                tertiary: "#222228",
            },
        },
    },
    plugins: []
}
