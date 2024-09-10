import { defineConfig } from 'vite';

import react from '@vitejs/plugin-react';
import laravel, { refreshPaths } from 'laravel-vite-plugin'
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.jsx', 'resources/css/filament/admin/theme.css'],
            refresh: true
        }),
        react(),
    ],
});
