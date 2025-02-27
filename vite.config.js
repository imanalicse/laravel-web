import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // 'resources/css/app.css',
                'resources/css/frontend.css',
                'resources/css/backend.css',
                // 'resources/js/app.js',
                'resources/js/frontend.js',
                'resources/js/backend.js',
            ],
            refresh: true,
        }),
    ],
});
