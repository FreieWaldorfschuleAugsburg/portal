/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./app/Views/**/*.{html,php}"],
    theme: {
        extend: {
            fontFamily: {
                'inter-bold': ['Inter Bold'],
                'inter-light': ['Inter Light'],
                'inter-medium': ['Inter Medium'],
                'inter-regular': ['Inter Regular'],
                'inter-semibold': ['Inter SemiBold'],
                'poppins-bold': ['Poppins Bold'],
                'poppins-light': ['Poppins Light'],
                'poppins-medium': ['Poppins Medium'],
                'poppins-regular': ['Poppins Regular'],
                'poppins-semibold': ['Poppins SemiBold'],

            },
            fontSize: {
                "h1-big": "50.52px",
                "h1-small": "37.9px",
                "h2-big": "28.4px",
                "h2-small": "21.3px",
                "body": "16px",
                "category": "14px",
                '2xs': '0.65rem',
                '3xs': '0.25rem'

            },
            lineHeight: {
                '24': "24px"
            },

            colors: {
                dark: '#0A0F1B'
            }
        },
    },
    plugins: [require("@tailwindcss/forms")],
}
