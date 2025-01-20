/** @type {import('tailwindcss').Config} */
// module.exports = {
//     content: [
//         "./resources/**/*.blade.php",
//         "./resources/**/*.js",
//         "./resources/**/*.vue",
//       ],
//   theme: {
//     extend: {},
//   },
//   plugins: [],
// }

module.exports = {
    content: [
        "node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx,vue}",
        "node_modules/flowbite/**/*.{js,jsx,ts,tsx}",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    plugins: [require("flowbite/plugin")],
    theme: {},
};
