import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/globals.css',
                'resources/css/style.css',
                'resources/css/style-teacher.css',
            ],
            refresh: true,
        }),
    ],
});
