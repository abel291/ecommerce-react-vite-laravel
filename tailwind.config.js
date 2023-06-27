const defaultTheme = require('tailwindcss/defaultTheme');
/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')
module.exports = {
	darkMode: 'class',
	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
		'./resources/js/**/*.jsx',

		//dashboard
		//"./resources/**/*.blade.php",
		"./resources/**/*.js",
		"./node_modules/flowbite/**/*.js"


	],

	theme: {
		colors: {
			...colors,
			primary: colors.green,
		},

		container: {
			center: true,
			padding: {
				DEFAULT: "1.5rem",
				sm: "2rem",
				lg: "4rem",
				xl: "5rem",
			},
		},
	},

	plugins: [require('@tailwindcss/forms'), require('flowbite/plugin')],




};
