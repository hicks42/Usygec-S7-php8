/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/**/*.{html,js,twig,html.twig}",
    "./app/templates/**/*.{html,js,twig,html.twig}",
  ],
  theme: {
    container: {
      center: true,
    },
    fontFamily: {
      title: ["Spartan", "sans serif"],
      text: ["ZillaSlab", "serif"],
      link: ["Ubuntu", "sans serif"],
    },
    extend: {},
  },
  plugins: [require("@tailwindcss/forms"), require("@tailwindcss/typography")],
};
