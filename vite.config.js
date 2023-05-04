import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
	plugins: [
		laravel({
			input: ['resources/js/app.jsx', 'resources/js/dashboard.js', 'resources/css/dashboard.css'],
			refresh: true,
		}),
		react(),
	],
});

//package.json
//"dev:back": "vite --config vite.dashboard.config.js",
//"build:back": "vite build --config vite.dashboard.config.js",
