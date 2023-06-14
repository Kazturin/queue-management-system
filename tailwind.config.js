/** @type {import('tailwindcss').Config} */
const colors = require("tailwindcss/colors");

module.exports = {
  content: [
      "./resources/**/*.blade.php",
      "./vendor/filament/**/*.blade.php"
  ],
    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.purple,
                success: colors.green,
                warning: colors.yellow,
                'light-blue' : '#396195',
                'strong-blue' : '#0c1c56'
            },
            fontFamily : {
                russoOne : [ "'RussoOne-Regular' , sans-serif" ],
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
}

