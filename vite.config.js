import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vuePlugin from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/live.js', 'resources/css/filament/admin/theme.css'],
            refresh: true,
        }),
        vuePlugin(),
    ],
});
